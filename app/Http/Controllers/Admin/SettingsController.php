<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $logo = SiteSetting::get('site_logo');
        return view('admin.settings.index', compact('logo'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'logo'        => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:1024',
            'remove_logo' => 'nullable|boolean',
        ]);

        $current = SiteSetting::get('site_logo');

        if ($request->hasFile('logo')) {
            if ($current) Storage::disk('public')->delete($current);
            SiteSetting::set('site_logo', $request->file('logo')->store('branding', 'public'));
        } elseif ($request->boolean('remove_logo')) {
            if ($current) Storage::disk('public')->delete($current);
            SiteSetting::set('site_logo', null);
        }

        return redirect()->route('admin.settings')->with('success', 'Branding updated.');
    }
}
