<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSlideController extends Controller
{
    public function index()
    {
        $slides = HeroSlide::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.hero-slides.index', compact('slides'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'eyebrow'    => 'nullable|string|max:100',
            'title'      => 'nullable|string|max:100',
            'title_gold' => 'nullable|string|max:100',
            'subtitle'   => 'nullable|string|max:200',
            'sort_order' => 'nullable|integer',
            'image'      => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
            'video'      => 'nullable|mimes:mp4,webm,ogg,mov|max:51200',
        ]);

        $validated['is_active'] = true;
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['image'] = $request->file('image')->store('hero', 'public');

        if ($request->hasFile('video')) {
            $validated['video'] = $request->file('video')->store('hero', 'public');
        }

        HeroSlide::create($validated);

        return redirect()->route('admin.hero-slides')->with('success', 'Slide added.');
    }

    public function update(Request $request, HeroSlide $heroSlide)
    {
        $validated = $request->validate([
            'eyebrow'      => 'nullable|string|max:100',
            'title'        => 'nullable|string|max:100',
            'title_gold'   => 'nullable|string|max:100',
            'subtitle'     => 'nullable|string|max:200',
            'sort_order'   => 'nullable|integer',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'video'        => 'nullable|mimes:mp4,webm,ogg,mov|max:51200',
            'remove_video' => 'nullable|boolean',
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            if ($heroSlide->image) Storage::disk('public')->delete($heroSlide->image);
            $validated['image'] = $request->file('image')->store('hero', 'public');
        }

        if ($request->hasFile('video')) {
            if ($heroSlide->video) Storage::disk('public')->delete($heroSlide->video);
            $validated['video'] = $request->file('video')->store('hero', 'public');
        } elseif ($request->boolean('remove_video')) {
            if ($heroSlide->video) Storage::disk('public')->delete($heroSlide->video);
            $validated['video'] = null;
        }

        unset($validated['remove_video']);
        $heroSlide->update($validated);

        return redirect()->route('admin.hero-slides')->with('success', 'Slide updated.');
    }

    public function destroy(HeroSlide $heroSlide)
    {
        if ($heroSlide->image) Storage::disk('public')->delete($heroSlide->image);
        if ($heroSlide->video) Storage::disk('public')->delete($heroSlide->video);
        $heroSlide->delete();
        return redirect()->route('admin.hero-slides')->with('success', 'Slide removed.');
    }

    public function toggleActive(HeroSlide $heroSlide)
    {
        $heroSlide->update(['is_active' => !$heroSlide->is_active]);
        return redirect()->back()->with('success', 'Slide visibility updated.');
    }
}
