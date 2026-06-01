<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['customer', 'service']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }
        if ($request->filled('date_from')) {
            $query->where('booking_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('booking_date', '<=', $request->date_to);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('customer', function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%");
            })->orWhere('confirmation_number', 'like', "%$search%");
        }

        $bookings = $query->orderByDesc('booking_date')
                          ->orderByDesc('booking_time')
                          ->paginate(15)
                          ->withQueryString();

        $services = Service::where('is_active', true)->orderBy('name')->get();

        // Calendar data
        $calendarBookings = Booking::with(['customer', 'service'])
            ->whereMonth('booking_date', $request->get('month', now()->month))
            ->whereYear('booking_date', $request->get('year', now()->year))
            ->get()
            ->map(fn($b) => [
                'id'       => $b->id,
                'title'    => $b->customer->full_name . ' – ' . $b->service->name,
                'date'     => $b->booking_date->toDateString(),
                'time'     => substr($b->booking_time, 0, 5),
                'status'   => $b->status,
                'category' => $b->service->category,
                'url'       => route('admin.bookings.show', $b->id),
            ]);

        return view('admin.bookings.index', compact('bookings', 'services', 'calendarBookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['customer', 'service', 'reminders']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id'  => 'required|exists:customers,id',
            'service_id'   => 'required|exists:services,id',
            'booking_date' => 'required|date',
            'booking_time' => 'required',
            'notes'        => 'nullable|string',
        ]);

        $customer = Customer::findOrFail($validated['customer_id']);
        $service  = Service::findOrFail($validated['service_id']);

        $discPct  = $customer->getApplicableDiscountPercentage();
        $original = $service->price_from;
        $discAmt  = round($original * $discPct / 100, 2);

        Booking::create(array_merge($validated, [
            'status'              => 'confirmed',
            'confirmation_number' => Booking::generateConfirmationNumber(),
            'consent_reminders'   => true,
            'original_price'      => $original,
            'discount_amount'     => $discAmt,
            'final_price'         => $original - $discAmt,
            'discount_label'      => $discPct > 0 ? "{$discPct}% discount" : null,
        ]));

        $customer->increment('total_bookings');
        $customer->increment('loyalty_points', 100);

        return redirect()->route('admin.bookings')->with('success', 'Booking created successfully.');
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status'       => 'sometimes|in:pending,confirmed,completed,cancelled',
            'booking_date' => 'sometimes|date',
            'booking_time' => 'sometimes|string',
            'notes'        => 'nullable|string',
        ]);

        $booking->update($validated);

        return redirect()->back()->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings')->with('success', 'Booking deleted.');
    }
}
