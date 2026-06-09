<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutCertification;
use App\Models\AboutValue;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
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

        $aboutValue->update($request->only('number', 'title', 'body', 'sort_order'));

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

        $aboutCertification->update($request->only('icon', 'label', 'sort_order'));

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
