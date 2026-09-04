<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    private const CATEGORIES = 'maternity_postop,body_treatments,skin_treatments,rejuvenation,body_enhancement';

    public function index()
    {
        $services = Service::orderBy('sort_order')->orderBy('name')->get();
        return view('admin.services.index', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:100',
            'category'          => 'required|in:' . self::CATEGORIES,
            'short_description' => 'required|string|max:300',
            'description'       => 'nullable|string|max:4000',
            'meta_title'        => 'nullable|string|max:160',
            'meta_description'  => 'nullable|string|max:300',
            'duration'          => 'required|string|max:50',
            'price_from'        => 'required|numeric|min:0',
            'sort_order'        => 'nullable|integer',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $validated['slug']      = Str::slug($validated['name']);
        $validated['is_active'] = true;
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        Service::create($validated);

        return redirect()->route('admin.services')->with('success', 'Service created successfully.');
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name'              => 'sometimes|string|max:100',
            'category'          => 'sometimes|in:' . self::CATEGORIES,
            'short_description' => 'sometimes|string|max:300',
            'description'       => 'nullable|string|max:4000',
            'meta_title'        => 'nullable|string|max:160',
            'meta_description'  => 'nullable|string|max:300',
            'duration'          => 'sometimes|string|max:50',
            'price_from'        => 'sometimes|numeric|min:0',
            'sort_order'        => 'nullable|integer',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'remove_image'      => 'nullable|boolean',
        ]);

        if (isset($validated['name'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        if (array_key_exists('sort_order', $validated)) {
            $validated['sort_order'] = $validated['sort_order'] ?? 0;
        }

        if ($request->hasFile('image')) {
            if ($service->image) Storage::disk('public')->delete($service->image);
            $validated['image'] = $request->file('image')->store('services', 'public');
        } elseif ($request->boolean('remove_image')) {
            if ($service->image) Storage::disk('public')->delete($service->image);
            $validated['image'] = null;
        }

        unset($validated['remove_image']);
        $service->update($validated);

        return redirect()->back()->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        if ($service->image) Storage::disk('public')->delete($service->image);
        $service->delete();
        return redirect()->route('admin.services')->with('success', 'Service deleted.');
    }

    public function toggleActive(Service $service)
    {
        $service->update(['is_active' => !$service->is_active]);
        $status = $service->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Service {$status}.");
    }
}
