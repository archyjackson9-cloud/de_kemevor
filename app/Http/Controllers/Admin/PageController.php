<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutCertification;
use App\Models\AboutValue;
use App\Models\HomeValue;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    // ── Home Page ─────────────────────────────────────────────────────────

    public function home()
    {
        $s            = SiteSetting::forPage('home_');
        $homeValues   = HomeValue::orderBy('sort_order')->orderBy('id')->get();
        $testimonials = Testimonial::orderBy('sort_order')->orderBy('id')->get();

        return view('admin.pages.home', compact('s', 'homeValues', 'testimonials'));
    }

    public function updateHome(Request $request)
    {
        $request->validate([
            'home_story_eyebrow'      => 'nullable|string|max:100',
            'home_story_title'        => 'nullable|string|max:150',
            'home_story_body'         => 'nullable|string|max:3000',
            'home_story_badge_num'    => 'nullable|string|max:20',
            'home_story_badge_label'  => 'nullable|string|max:60',
            'home_story_media'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:51200',
            'home_services_eyebrow'   => 'nullable|string|max:100',
            'home_services_title'     => 'nullable|string|max:150',
            'home_services_sub'       => 'nullable|string|max:300',
            'home_why_eyebrow'        => 'nullable|string|max:100',
            'home_why_title'          => 'nullable|string|max:150',
            'home_why_backdrop'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
            'home_gallery_eyebrow'    => 'nullable|string|max:100',
            'home_gallery_sub'        => 'nullable|string|max:300',
            'home_cta_title'          => 'nullable|string|max:150',
            'home_cta_sub'            => 'nullable|string|max:300',
        ]);

        $keys = [
            'home_story_eyebrow', 'home_story_title', 'home_story_body',
            'home_story_badge_num', 'home_story_badge_label',
            'home_services_eyebrow', 'home_services_title', 'home_services_sub',
            'home_why_eyebrow', 'home_why_title',
            'home_gallery_eyebrow', 'home_gallery_sub',
            'home_cta_title', 'home_cta_sub',
        ];

        $data = [];
        foreach ($keys as $key) {
            $data[$key] = $request->input($key);
        }

        if ($request->boolean('home_remove_story_media')) {
            $existing = SiteSetting::get('home_story_media');
            if ($existing) Storage::disk('public')->delete($existing);
            $data['home_story_media'] = null;
        } elseif ($request->hasFile('home_story_media')) {
            $existing = SiteSetting::get('home_story_media');
            if ($existing) Storage::disk('public')->delete($existing);
            $data['home_story_media'] = $request->file('home_story_media')->store('pages', 'public');
        }

        if ($request->boolean('home_remove_why_backdrop')) {
            $existing = SiteSetting::get('home_why_backdrop');
            if ($existing) Storage::disk('public')->delete($existing);
            $data['home_why_backdrop'] = null;
        } elseif ($request->hasFile('home_why_backdrop')) {
            $existing = SiteSetting::get('home_why_backdrop');
            if ($existing) Storage::disk('public')->delete($existing);
            $data['home_why_backdrop'] = $request->file('home_why_backdrop')->store('pages', 'public');
        }

        SiteSetting::setMany($data);

        return redirect()->route('admin.pages.home')->with('success', 'Home page settings saved.');
    }

    // ── Home "Why Choose Us" Value Cards ────────────────────────────────────

    public function storeHomeValue(Request $request)
    {
        $request->validate([
            'image'      => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'icon'       => 'nullable|string|max:50',
            'title'      => 'required|string|max:100',
            'body'       => 'required|string|max:500',
            'sort_order' => 'nullable|integer',
        ]);

        HomeValue::create([
            'image'      => $request->file('image')->store('home-values', 'public'),
            'icon'       => $request->icon,
            'title'      => $request->title,
            'body'       => $request->body,
            'sort_order' => $request->sort_order ?? 0,
            'is_active'  => true,
        ]);

        return redirect()->route('admin.pages.home')->with('success', 'Value card added.');
    }

    public function updateHomeValue(Request $request, HomeValue $homeValue)
    {
        $request->validate([
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'icon'       => 'nullable|string|max:50',
            'title'      => 'required|string|max:100',
            'body'       => 'required|string|max:500',
            'sort_order' => 'nullable|integer',
        ]);

        $data = $request->only('icon', 'title', 'body', 'sort_order');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            if ($homeValue->image) Storage::disk('public')->delete($homeValue->image);
            $data['image'] = $request->file('image')->store('home-values', 'public');
        }

        $homeValue->update($data);

        return redirect()->route('admin.pages.home')->with('success', 'Value card updated.');
    }

    public function destroyHomeValue(HomeValue $homeValue)
    {
        if ($homeValue->image) Storage::disk('public')->delete($homeValue->image);
        $homeValue->delete();
        return redirect()->route('admin.pages.home')->with('success', 'Value card deleted.');
    }

    public function toggleHomeValue(HomeValue $homeValue)
    {
        $homeValue->update(['is_active' => !$homeValue->is_active]);
        return redirect()->back()->with('success', 'Value card visibility updated.');
    }

    // ── Home Testimonials ────────────────────────────────────────────────────

    public function storeTestimonial(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:100',
            'quote'      => 'required|string|max:500',
            'sort_order' => 'nullable|integer',
        ]);

        Testimonial::create([
            'name'       => $request->name,
            'quote'      => $request->quote,
            'sort_order' => $request->sort_order ?? 0,
            'is_active'  => true,
        ]);

        return redirect()->route('admin.pages.home')->with('success', 'Testimonial added.');
    }

    public function updateTestimonial(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'name'       => 'required|string|max:100',
            'quote'      => 'required|string|max:500',
            'sort_order' => 'nullable|integer',
        ]);

        $data = $request->only('name', 'quote', 'sort_order');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $testimonial->update($data);

        return redirect()->route('admin.pages.home')->with('success', 'Testimonial updated.');
    }

    public function destroyTestimonial(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->route('admin.pages.home')->with('success', 'Testimonial deleted.');
    }

    public function toggleTestimonial(Testimonial $testimonial)
    {
        $testimonial->update(['is_active' => !$testimonial->is_active]);
        return redirect()->back()->with('success', 'Testimonial visibility updated.');
    }

    // ── About Page ────────────────────────────────────────────────────────

    public function about()
    {
        $s      = SiteSetting::forPage('about_');
        $values = AboutValue::orderBy('sort_order')->orderBy('id')->get();
        $certs  = AboutCertification::orderBy('sort_order')->orderBy('id')->get();

        return view('admin.pages.about', compact('s', 'values', 'certs'));
    }

    public function updateAbout(Request $request)
    {
        $request->validate([
            'about_hero_eyebrow'  => 'nullable|string|max:100',
            'about_hero_title'    => 'nullable|string|max:150',
            'about_hero_sub'      => 'nullable|string|max:300',
            'about_hero_type'     => 'nullable|in:none,image,video',
            'about_hero_media'    => 'nullable|file|mimes:jpeg,png,jpg,webp,mp4,webm|max:51200',
            'about_story_eyebrow' => 'nullable|string|max:100',
            'about_story_title'   => 'nullable|string|max:150',
            'about_story_body'    => 'nullable|string|max:3000',
            'about_stat_1_num'    => 'nullable|string|max:20',
            'about_stat_1_label'  => 'nullable|string|max:60',
            'about_stat_2_num'    => 'nullable|string|max:20',
            'about_stat_2_label'  => 'nullable|string|max:60',
            'about_stat_3_num'    => 'nullable|string|max:20',
            'about_stat_3_label'  => 'nullable|string|max:60',
            'about_stat_4_num'    => 'nullable|string|max:20',
            'about_stat_4_label'  => 'nullable|string|max:60',
            'about_mission'       => 'nullable|string|max:500',
            'about_cta_title'     => 'nullable|string|max:150',
            'about_cta_sub'       => 'nullable|string|max:300',
        ]);

        $keys = [
            'about_hero_eyebrow','about_hero_title','about_hero_sub','about_hero_type',
            'about_story_eyebrow','about_story_title','about_story_body',
            'about_stat_1_num','about_stat_1_label','about_stat_2_num','about_stat_2_label',
            'about_stat_3_num','about_stat_3_label','about_stat_4_num','about_stat_4_label',
            'about_mission','about_cta_title','about_cta_sub',
        ];

        $data = [];
        foreach ($keys as $key) {
            $data[$key] = $request->input($key);
        }

        if ($request->boolean('about_remove_media')) {
            $existing = SiteSetting::get('about_hero_media');
            if ($existing) Storage::disk('public')->delete($existing);
            $data['about_hero_media'] = null;
        } elseif ($request->hasFile('about_hero_media')) {
            $existing = SiteSetting::get('about_hero_media');
            if ($existing) Storage::disk('public')->delete($existing);
            $data['about_hero_media'] = $request->file('about_hero_media')->store('pages', 'public');
        }

        SiteSetting::setMany($data);

        return redirect()->route('admin.pages.about')->with('success', 'About page settings saved.');
    }

    // ── About Values ─────────────────────────────────────────────────────

    public function storeValue(Request $request)
    {
        $request->validate([
            'number'     => 'required|string|max:5',
            'title'      => 'required|string|max:100',
            'body'       => 'required|string|max:500',
            'sort_order' => 'nullable|integer',
        ]);

        AboutValue::create([
            'number'     => $request->number,
            'title'      => $request->title,
            'body'       => $request->body,
            'sort_order' => $request->sort_order ?? 0,
            'is_active'  => true,
        ]);

        return redirect()->route('admin.pages.about')->with('success', 'Core value added.');
    }

    public function updateValue(Request $request, AboutValue $aboutValue)
    {
        $request->validate([
            'number'     => 'required|string|max:5',
            'title'      => 'required|string|max:100',
            'body'       => 'required|string|max:500',
            'sort_order' => 'nullable|integer',
        ]);

        $data = $request->only('number', 'title', 'body', 'sort_order');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $aboutValue->update($data);

        return redirect()->route('admin.pages.about')->with('success', 'Core value updated.');
    }

    public function destroyValue(AboutValue $aboutValue)
    {
        $aboutValue->delete();
        return redirect()->route('admin.pages.about')->with('success', 'Core value deleted.');
    }

    public function toggleValue(AboutValue $aboutValue)
    {
        $aboutValue->update(['is_active' => !$aboutValue->is_active]);
        return redirect()->back()->with('success', 'Value visibility updated.');
    }

    // ── About Certifications ──────────────────────────────────────────────

    public function storeCert(Request $request)
    {
        $request->validate([
            'icon'       => 'required|string|max:50',
            'label'      => 'required|string|max:150',
            'sort_order' => 'nullable|integer',
        ]);

        AboutCertification::create([
            'icon'       => $request->icon,
            'label'      => $request->label,
            'sort_order' => $request->sort_order ?? 0,
            'is_active'  => true,
        ]);

        return redirect()->route('admin.pages.about')->with('success', 'Certification added.');
    }

    public function updateCert(Request $request, AboutCertification $aboutCertification)
    {
        $request->validate([
            'icon'       => 'required|string|max:50',
            'label'      => 'required|string|max:150',
            'sort_order' => 'nullable|integer',
        ]);

        $data = $request->only('icon', 'label', 'sort_order');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $aboutCertification->update($data);

        return redirect()->route('admin.pages.about')->with('success', 'Certification updated.');
    }

    public function destroyCert(AboutCertification $aboutCertification)
    {
        $aboutCertification->delete();
        return redirect()->route('admin.pages.about')->with('success', 'Certification deleted.');
    }

    public function toggleCert(AboutCertification $aboutCertification)
    {
        $aboutCertification->update(['is_active' => !$aboutCertification->is_active]);
        return redirect()->back()->with('success', 'Certification visibility updated.');
    }

    // ── Contact Page ──────────────────────────────────────────────────────

    public function contact()
    {
        $s = SiteSetting::forPage('contact_');
        return view('admin.pages.contact', compact('s'));
    }

    public function updateContact(Request $request)
    {
        $request->validate([
            'contact_hero_eyebrow' => 'nullable|string|max:100',
            'contact_hero_title'   => 'nullable|string|max:150',
            'contact_hero_sub'     => 'nullable|string|max:300',
            'contact_hero_type'    => 'nullable|in:none,image,video',
            'contact_hero_media'   => 'nullable|file|mimes:jpeg,png,jpg,webp,mp4,webm|max:51200',
            'contact_phone'        => 'nullable|string|max:30',
            'contact_website'      => 'nullable|url|max:255',
            'contact_location'     => 'nullable|string|max:300',
            'contact_hours'        => 'nullable|string|max:500',
            'contact_ig_handle'    => 'nullable|string|max:60',
            'contact_ig_url'       => 'nullable|url|max:255',
            'contact_tt_handle'    => 'nullable|string|max:60',
            'contact_tt_url'       => 'nullable|url|max:255',
            'contact_fb_handle'    => 'nullable|string|max:60',
            'contact_fb_url'       => 'nullable|url|max:255',
            'contact_sc_handle'    => 'nullable|string|max:60',
            'contact_sc_url'       => 'nullable|url|max:255',
            'contact_map_embed'    => 'nullable|string|max:2000',
        ]);

        $keys = [
            'contact_hero_eyebrow','contact_hero_title','contact_hero_sub','contact_hero_type',
            'contact_phone','contact_website','contact_location','contact_hours',
            'contact_ig_handle','contact_ig_url','contact_tt_handle','contact_tt_url',
            'contact_fb_handle','contact_fb_url','contact_sc_handle','contact_sc_url',
            'contact_map_embed',
        ];

        $data = [];
        foreach ($keys as $key) {
            $data[$key] = $request->input($key);
        }

        if ($request->boolean('contact_remove_media')) {
            $existing = SiteSetting::get('contact_hero_media');
            if ($existing) Storage::disk('public')->delete($existing);
            $data['contact_hero_media'] = null;
        } elseif ($request->hasFile('contact_hero_media')) {
            $existing = SiteSetting::get('contact_hero_media');
            if ($existing) Storage::disk('public')->delete($existing);
            $data['contact_hero_media'] = $request->file('contact_hero_media')->store('pages', 'public');
        }

        SiteSetting::setMany($data);

        return redirect()->route('admin.pages.contact')->with('success', 'Contact page settings saved.');
    }
}
