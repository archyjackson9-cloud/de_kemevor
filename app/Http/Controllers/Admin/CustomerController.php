<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerDiscount;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::withCount('bookings');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('first_name', 'like', "%$s%")
                  ->orWhere('last_name', 'like', "%$s%")
                  ->orWhere('email', 'like', "%$s%")
                  ->orWhere('phone', 'like', "%$s%");
            });
        }
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }
        if ($request->filled('tier')) {
            $query->where('discount_tier', $request->tier);
        }

        $customers = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        return view('admin.customers.index', compact('customers'));
    }

    public function show(Customer $customer)
    {
        $customer->load(['bookings.service', 'discounts']);
        return view('admin.customers.show', compact('customer'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'    => 'required|string|max:50',
            'last_name'     => 'required|string|max:50',
            'email'         => 'required|email|unique:customers,email',
            'phone'         => 'required|string|max:20',
            'gender'        => 'required|in:female,male,prefer_not_to_say',
            'date_of_birth' => 'nullable|date',
            'health_notes'  => 'nullable|string',
        ]);

        Customer::create(array_merge($validated, ['discount_tier' => 'new_client']));

        return redirect()->route('admin.customers')->with('success', 'Customer added successfully.');
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'first_name'    => 'sometimes|string|max:50',
            'last_name'     => 'sometimes|string|max:50',
            'phone'         => 'sometimes|string|max:20',
            'gender'        => 'sometimes|in:female,male,prefer_not_to_say',
            'date_of_birth' => 'nullable|date',
            'health_notes'  => 'nullable|string',
            'discount_tier' => 'sometimes|in:none,new_client,loyal,special',
        ]);

        $customer->update($validated);

        return redirect()->back()->with('success', 'Customer updated successfully.');
    }
}
