<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Reminder;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    public function index()
    {
        $reminders       = Reminder::with(['booking.service', 'customer'])->orderByDesc('sent_at')->paginate(20);
        $smsEnabled      = config('healing.reminders.sms_enabled', true);
        $emailEnabled    = config('healing.reminders.email_enabled', true);
        $pendingBookings = Booking::with(['customer', 'service'])
            ->where('booking_date', '>=', now())
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('booking_date')
            ->get();

        return view('admin.reminders.index', compact('reminders', 'smsEnabled', 'emailEnabled', 'pendingBookings'));
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'type'       => 'required|in:sms,email',
            'message'    => 'nullable|string|max:500',
        ]);

        $booking = Booking::with(['customer', 'service'])->findOrFail($validated['booking_id']);

        $defaultMsg = $validated['type'] === 'sms'
            ? "Hi {$booking->customer->first_name}, reminder: your {$booking->service->name} appointment is on {$booking->booking_date->format('D, M j')} at " . substr($booking->booking_time, 0, 5) . ". – The Healing Room"
            : "Dear {$booking->customer->first_name}, this is a friendly reminder of your upcoming appointment for {$booking->service->name} on {$booking->booking_date->format('l, F j, Y')} at " . substr($booking->booking_time, 0, 5) . ". We look forward to seeing you! – The Healing Room";

        Reminder::create([
            'booking_id'  => $booking->id,
            'customer_id' => $booking->customer_id,
            'type'        => $validated['type'],
            'status'      => 'sent',
            'sent_at'     => now(),
            'message'     => $validated['message'] ?? $defaultMsg,
        ]);

        return redirect()->route('admin.reminders')
            ->with('success', ucfirst($validated['type']) . " reminder sent to {$booking->customer->full_name}.");
    }

    public function toggle(Request $request)
    {
        // Store toggle state in session (simulated — no real DB config store)
        $type    = $request->input('type');   // 'sms' or 'email'
        $enabled = (bool) $request->input('enabled', true);
        session(["reminder_{$type}_enabled" => $enabled]);
        return response()->json(['ok' => true]);
    }

    public function autoProcess()
    {
        // Simulate auto-reminders: 24h SMS + 48h Email
        $tomorrow  = now()->addDay()->toDateString();
        $dayAfter  = now()->addDays(2)->toDateString();

        $smsBookings = Booking::with(['customer', 'service'])
            ->where('booking_date', $tomorrow)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('consent_reminders', true)
            ->get();

        foreach ($smsBookings as $booking) {
            $alreadySent = Reminder::where('booking_id', $booking->id)
                ->where('type', 'sms')->exists();
            if (!$alreadySent) {
                Reminder::create([
                    'booking_id'  => $booking->id,
                    'customer_id' => $booking->customer_id,
                    'type'        => 'sms',
                    'status'      => 'sent',
                    'sent_at'     => now(),
                    'message'     => "Hi {$booking->customer->first_name}, your {$booking->service->name} appointment is tomorrow at " . substr($booking->booking_time, 0, 5) . ". – The Healing Room",
                ]);
            }
        }

        $emailBookings = Booking::with(['customer', 'service'])
            ->where('booking_date', $dayAfter)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('consent_reminders', true)
            ->get();

        foreach ($emailBookings as $booking) {
            $alreadySent = Reminder::where('booking_id', $booking->id)
                ->where('type', 'email')->exists();
            if (!$alreadySent) {
                Reminder::create([
                    'booking_id'  => $booking->id,
                    'customer_id' => $booking->customer_id,
                    'type'        => 'email',
                    'status'      => 'sent',
                    'sent_at'     => now(),
                    'message'     => "Dear {$booking->customer->first_name}, reminder: {$booking->service->name} on {$booking->booking_date->format('l, F j, Y')} at " . substr($booking->booking_time, 0, 5) . ". – The Healing Room",
                ]);
            }
        }

        return redirect()->route('admin.reminders')->with('success', 'Auto-reminders processed.');
    }
}
