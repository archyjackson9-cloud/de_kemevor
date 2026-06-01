<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerDiscount;
use App\Models\PromoCode;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index()
    {
        $promoCodes         = PromoCode::orderByDesc('created_at')->get();
        $customers          = Customer::orderBy('first_name')->get();
        $customerDiscounts  = CustomerDiscount::with('customer')->orderByDesc('created_at')->get();

        return view('admin.discounts.index', compact('promoCodes', 'customers', 'customerDiscounts'));
    }

    public function storePromo(Request $request)
    {
        $validated = $request->validate([
            'code'        => 'required|string|max:20|unique:promo_codes,code',
            'percentage'  => 'required|integer|min:1|max:100',
            'expiry_date' => 'nullable|date|after:today',
            'usage_limit' => 'nullable|integer|min:1',
        ]);

        $validated['is_active']   = true;
        $validated['used_count']  = 0;

        PromoCode::create($validated);

        return redirect()->route('admin.discounts')->with('success', 'Promo code created.');
    }

    public function togglePromo(PromoCode $promoCode)
    {
        $promoCode->update(['is_active' => !$promoCode->is_active]);
        return redirect()->back()->with('success', 'Promo code updated.');
    }

    public function destroyPromo(PromoCode $promoCode)
    {
        $promoCode->delete();
        return redirect()->route('admin.discounts')->with('success', 'Promo code deleted.');
    }

    public function assignDiscount(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'percentage'  => 'required|integer|min:1|max:50',
            'expiry_date' => 'nullable|date|after:today',
        ]);

        $customer = Customer::findOrFail($validated['customer_id']);

        CustomerDiscount::create([
            'customer_id' => $customer->id,
            'type'        => 'special',
            'percentage'  => $validated['percentage'],
            'expiry_date' => $validated['expiry_date'] ?? null,
            'is_active'   => true,
        ]);

        $customer->update(['discount_tier' => 'special']);

        return redirect()->route('admin.discounts')->with('success', "Special discount assigned to {$customer->full_name}.");
    }

    public function revokeDiscount(CustomerDiscount $customerDiscount)
    {
        $customer = $customerDiscount->customer;
        $customerDiscount->update(['is_active' => false]);

        // Recalculate tier
        $hasActive = $customer->discounts()->where('is_active', true)->exists();
        if (!$hasActive) {
            $tier = $customer->total_bookings >= 5 ? 'loyal' : ($customer->total_bookings === 0 ? 'new_client' : 'none');
            $customer->update(['discount_tier' => $tier]);
        }

        return redirect()->back()->with('success', 'Discount revoked.');
    }
}
