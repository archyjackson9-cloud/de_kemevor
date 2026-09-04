<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\PromoCode;
use App\Models\Service;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $categories = [
            'maternity_postop' => ['label' => 'Maternity & Post-Op Care', 'icon' => '🤱', 'color' => 'pink'],
            'body_treatments'  => ['label' => 'Body Treatments',          'icon' => '💆', 'color' => 'teal'],
            'skin_treatments'  => ['label' => 'Skin Treatments',          'icon' => '✨', 'color' => 'amber'],
            'rejuvenation'     => ['label' => 'Rejuvenation',             'icon' => '🌸', 'color' => 'purple'],
            'body_enhancement' => ['label' => 'Body Enhancement',         'icon' => '💪', 'color' => 'green'],
        ];

        $services = Service::where('is_active', true)->orderBy('sort_order')->get();
        $grouped  = $services->groupBy('category');

        $servicesByCategory = [];
        foreach ($categories as $key => $meta) {
            if (empty($grouped[$key]) || $grouped[$key]->isEmpty()) continue;

            $coverService = $grouped[$key]->first(fn ($s) => (bool) $s->image);

            $servicesByCategory[$key] = [
                'meta'     => $meta,
                'services' => $grouped[$key],
                'cover'    => $coverService?->image_url,
            ];
        }

        $preselectedService = $request->query('service');

        return view('booking.index', compact('services', 'servicesByCategory', 'preselectedService'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id'        => 'required|exists:services,id',
            'booking_date'      => 'required|date|after_or_equal:today',
            'booking_time'      => 'required|string',
            'first_name'        => 'required|string|max:50',
            'last_name'         => 'required|string|max:50',
            'phone'             => 'required|string|max:20',
            'email'             => 'required|email',
            'gender'            => 'required|in:female,male,prefer_not_to_say',
            'date_of_birth'     => 'nullable|date',
            'notes'             => 'nullable|string|max:1000',
            'consent_reminders' => 'nullable|boolean',
            'promo_code'        => 'nullable|string|max:20',
        ]);

        // Find or create customer
        $customer = Customer::where('email', $validated['email'])->first();
        $isNew    = !$customer;

        if (!$customer) {
            $customer = Customer::create([
                'first_name'    => $validated['first_name'],
                'last_name'     => $validated['last_name'],
                'email'         => $validated['email'],
                'phone'         => $validated['phone'],
                'gender'        => $validated['gender'],
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'health_notes'  => $validated['notes'] ?? null,
                'discount_tier' => 'new_client',
                'total_bookings'=> 0,
                'loyalty_points'=> 0,
            ]);
        } else {
            $customer->update([
                'phone'         => $validated['phone'],
                'date_of_birth' => $validated['date_of_birth'] ?? $customer->date_of_birth,
            ]);
        }

        $service = Service::findOrFail($validated['service_id']);

        // Calculate pricing
        $discPct   = $customer->getApplicableDiscountPercentage();
        $discLabel = null;

        // Check promo code
        if (!empty($validated['promo_code'])) {
            $promo = PromoCode::where('code', strtoupper($validated['promo_code']))->first();
            if ($promo && $promo->isValid()) {
                if ($promo->percentage > $discPct) {
                    $discPct   = $promo->percentage;
                    $discLabel = "Promo code {$promo->code} ({$promo->percentage}% off)";
                    $promo->increment('used_count');
                }
            }
        }

        if (!$discLabel && $discPct > 0) {
            $discLabel = $customer->discountLabel;
        }

        $original = $service->price_from;
        $discAmt  = round($original * $discPct / 100, 2);
        $final    = $original - $discAmt;

        $booking = Booking::create([
            'customer_id'         => $customer->id,
            'service_id'          => $service->id,
            'booking_date'        => $validated['booking_date'],
            'booking_time'        => $validated['booking_time'],
            'status'              => 'pending',
            'confirmation_number' => Booking::generateConfirmationNumber(),
            'notes'               => $validated['notes'] ?? null,
            'consent_reminders'   => (bool)($validated['consent_reminders'] ?? false),
            'original_price'      => $original,
            'discount_amount'     => $discAmt,
            'final_price'         => $final,
            'discount_label'      => $discLabel,
        ]);

        // Update customer stats
        $customer->increment('total_bookings');
        $customer->increment('loyalty_points', 100);

        // Auto-upgrade to loyal tier once the configured booking threshold is reached
        if ($customer->total_bookings >= Customer::loyalMinBookings() && $customer->discount_tier !== 'special') {
            $customer->update(['discount_tier' => 'loyal']);
        }

        return redirect()->route('booking.success', $booking->confirmation_number);
    }

    public function success(string $confirmationNumber)
    {
        $booking = Booking::with(['customer', 'service'])
            ->where('confirmation_number', $confirmationNumber)
            ->firstOrFail();

        return view('booking.success', compact('booking'));
    }

    public function checkPromo(Request $request)
    {
        $code  = strtoupper(trim($request->query('code', '')));
        if (!$code) {
            return response()->json(['valid' => false, 'message' => 'Please enter a promo code.']);
        }

        $promo = PromoCode::where('code', $code)->first();

        if (!$promo || !$promo->isValid()) {
            return response()->json(['valid' => false, 'message' => 'This code is invalid or expired.']);
        }

        return response()->json([
            'valid'   => true,
            'message' => "Code applied: {$promo->percentage}% off your booking!",
        ]);
    }

    public function getAvailableSlots(Request $request)
    {
        $date = $request->query('date');
        if (!$date) return response()->json([]);

        $allSlots = [
            '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
            '12:00', '13:00', '13:30', '14:00', '14:30', '15:00',
            '15:30', '16:00', '16:30', '17:00',
        ];

        $booked = Booking::where('booking_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('booking_time')
            ->map(fn($t) => substr($t, 0, 5))
            ->toArray();

        $slots = array_map(fn($slot) => [
            'time'      => $slot,
            'available' => !in_array($slot, $booked),
        ], $allSlots);

        return response()->json($slots);
    }
}
