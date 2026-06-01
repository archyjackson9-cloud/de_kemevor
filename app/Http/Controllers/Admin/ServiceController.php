<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('sort_order')->orderBy('name')->get();
        return view('admin.services.index', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:100',
            'category'          => 'required|in:maternity_postop,body_treatments,skin_treatments,rejuvenation',
            'short_description' => 'required|string|max:300',
            'description'       => 'nullable|string',
            'duration'          => 'required|string|max:50',
            'price_from'        => 'required|numeric|min:0',
            'sort_order'        => 'nullable|integer',
        ]);

        $validated['slug']      = Str::slug($validated['name']);
        $validated['is_active'] = true;

        Service::create($validated);

        return redirect()->route('admin.services')->with('success', 'Service created successfully.');
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name'              => 'sometimes|string|max:100',
            'category'          => 'sometimes|in:maternity_postop,body_treatments,skin_treatments,rejuvenation',
            'short_description' => 'sometimes|string|max:300',
            'description'       => 'nullable|string',
            'duration'          => 'sometimes|string|max:50',
            'price_from'        => 'sometimes|numeric|min:0',
            'is_active'         => 'sometimes|boolean',
            'sort_order'        => 'nullable|integer',
        ]);

        if (isset($validated['name'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $service->update($validated);

        return redirect()->back()->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
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
