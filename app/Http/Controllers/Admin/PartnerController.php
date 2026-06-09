<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::orderBy('sort_order')->orderBy('name')->get();
        return view('admin.partners.index', compact('partners'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'website_url' => 'nullable|url|max:255',
            'sort_order'  => 'nullable|integer',
            'logo'        => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ]);

        $validated['is_active'] = true;

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('partners', 'public');
        }

        Partner::create($validated);

        return redirect()->route('admin.partners')->with('success', 'Partner added.');
    }

    public function update(Request $request, Partner $partner)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:100',
            'website_url'  => 'nullable|url|max:255',
            'sort_order'   => 'nullable|integer',
            'logo'         => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'remove_logo'  => 'nullable|boolean',
        ]);

        if ($request->hasFile('logo')) {
            if ($partner->logo) Storage::disk('public')->delete($partner->logo);
            $validated['logo'] = $request->file('logo')->store('partners', 'public');
        } elseif ($request->boolean('remove_logo')) {
            if ($partner->logo) Storage::disk('public')->delete($partner->logo);
            $validated['logo'] = null;
        }

        unset($validated['remove_logo']);
        $partner->update($validated);

        return redirect()->route('admin.partners')->with('success', 'Partner updated.');
    }

    public function destroy(Partner $partner)
    {
        if ($partner->logo) Storage::disk('public')->delete($partner->logo);
        $partner->delete();
        return redirect()->route('admin.partners')->with('success', 'Partner removed.');
    }

    public function toggleActive(Partner $partner)
    {
        $partner->update(['is_active' => !$partner->is_active]);
        return redirect()->back()->with('success', 'Partner visibility updated.');
    }
}
