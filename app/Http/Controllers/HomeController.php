<?php

namespace App\Http\Controllers;

use App\Models\HeroSlide;
use App\Models\HomeValue;
use App\Models\Partner;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\TeamMember;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $featuredServices = Service::where('is_active', true)
            ->orderBy('sort_order')
            ->limit(6)
            ->get();

        $partners = Partner::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $heroSlides = HeroSlide::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        // First team member with a photo, for the home page story teaser
        // (unless the admin has uploaded a dedicated story photo below).
        $storyMember = TeamMember::where('is_active', true)
            ->whereNotNull('image')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->first();

        // Real treatment photos for the gallery strip (falls back to placeholder tiles in the view).
        $galleryImages = Service::where('is_active', true)
            ->whereNotNull('image')
            ->where('image', '!=', '')
            ->orderBy('sort_order')
            ->limit(6)
            ->get(['name', 'image', 'slug']);

        // A photographic backdrop for the dark "Why Choose Us" and CTA sections.
        $backdropService = $featuredServices->first(fn ($s) => (bool) $s->image);

        // Admin-editable text content + repeatable content for the home page.
        $s            = SiteSetting::forPage('home_');
        $homeValues   = HomeValue::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get();
        $testimonials = Testimonial::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get();

        return view('home', compact(
            'featuredServices', 'partners', 'heroSlides',
            'storyMember', 'galleryImages', 'backdropService',
            's', 'homeValues', 'testimonials'
        ));
    }
}
