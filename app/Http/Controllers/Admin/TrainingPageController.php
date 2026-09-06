<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\TrainingGainItem;
use App\Models\TrainingLearnPoint;
use App\Models\TrainingPhase;
use App\Models\TrainingWhoFor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrainingPageController extends Controller
{
    // ── Training Page Settings ──────────────────────────────────────────────

    public function index()
    {
        $s           = SiteSetting::forPage('training_');
        $phases      = TrainingPhase::orderBy('sort_order')->orderBy('phase_number')->get();
        $whoFor      = TrainingWhoFor::orderBy('sort_order')->orderBy('id')->get();
        $learnPoints = TrainingLearnPoint::orderBy('sort_order')->orderBy('id')->get();
        $gainItems   = TrainingGainItem::orderBy('sort_order')->orderBy('id')->get();

        return view('admin.pages.training', compact('s', 'phases', 'whoFor', 'learnPoints', 'gainItems'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'training_hero_eyebrow'       => 'nullable|string|max:100',
            'training_hero_title'         => 'nullable|string|max:150',
            'training_hero_sub'           => 'nullable|string|max:400',
            'training_hero_type'          => 'nullable|in:none,image,video',
            'training_hero_media'         => 'nullable|file|mimes:jpeg,png,jpg,webp,mp4,webm|max:51200',
            'training_hero_poster'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'training_description_eyebrow'=> 'nullable|string|max:100',
            'training_description_title'  => 'nullable|string|max:150',
            'training_description'        => 'nullable|string|max:3000',
            'training_who_eyebrow'        => 'nullable|string|max:100',
            'training_who_title'          => 'nullable|string|max:150',
            'training_learn_eyebrow'      => 'nullable|string|max:100',
            'training_learn_title'        => 'nullable|string|max:150',
            'training_gain_eyebrow'       => 'nullable|string|max:100',
            'training_gain_title'         => 'nullable|string|max:150',
            'training_structure_eyebrow'  => 'nullable|string|max:100',
            'training_structure_title'    => 'nullable|string|max:150',
            'training_structure_sub'      => 'nullable|string|max:300',
            'training_cert_eyebrow'       => 'nullable|string|max:100',
            'training_cert_title'         => 'nullable|string|max:150',
            'training_cert_body'          => 'nullable|string|max:2000',
            'training_enroll_title'       => 'nullable|string|max:150',
        ]);

        $keys = [
            'training_hero_eyebrow', 'training_hero_title', 'training_hero_sub', 'training_hero_type',
            'training_description_eyebrow', 'training_description_title', 'training_description',
            'training_who_eyebrow', 'training_who_title',
            'training_learn_eyebrow', 'training_learn_title',
            'training_gain_eyebrow', 'training_gain_title',
            'training_structure_eyebrow', 'training_structure_title', 'training_structure_sub',
            'training_cert_eyebrow', 'training_cert_title', 'training_cert_body',
            'training_enroll_title',
        ];

        $data = [];
        foreach ($keys as $key) {
            $data[$key] = $request->input($key);
        }

        if ($request->boolean('training_remove_media')) {
            $existing = SiteSetting::get('training_hero_media');
            if ($existing) Storage::disk('public')->delete($existing);
            $data['training_hero_media'] = null;
        } elseif ($request->hasFile('training_hero_media')) {
            $existing = SiteSetting::get('training_hero_media');
            if ($existing) Storage::disk('public')->delete($existing);
            $data['training_hero_media'] = $request->file('training_hero_media')->store('pages', 'public');
        }

        if ($request->hasFile('training_hero_poster')) {
            $existingPoster = SiteSetting::get('training_hero_poster');
            if ($existingPoster) Storage::disk('public')->delete($existingPoster);
            $data['training_hero_poster'] = $request->file('training_hero_poster')->store('pages', 'public');
        }

        SiteSetting::setMany($data);

        return redirect()->route('admin.pages.training')->with('success', 'Training page settings saved.');
    }

    // ── Phases ───────────────────────────────────────────────────────────────

    public function storePhase(Request $request)
    {
        $request->validate([
            'phase_number' => 'required|integer|min:1|max:99',
            'title'        => 'required|string|max:150',
            'subtitle'     => 'nullable|string|max:200',
            'description'  => 'nullable|string|max:2000',
            'topics'       => 'nullable|string|max:2000',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'sort_order'   => 'nullable|integer',
        ]);

        $data = $request->only('phase_number', 'title', 'subtitle', 'description', 'topics', 'sort_order');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = true;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('training', 'public');
        }

        TrainingPhase::create($data);

        return redirect()->route('admin.pages.training')->with('success', 'Phase added.');
    }

    public function updatePhase(Request $request, TrainingPhase $phase)
    {
        $request->validate([
            'phase_number' => 'required|integer|min:1|max:99',
            'title'        => 'required|string|max:150',
            'subtitle'     => 'nullable|string|max:200',
            'description'  => 'nullable|string|max:2000',
            'topics'       => 'nullable|string|max:2000',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'sort_order'   => 'nullable|integer',
        ]);

        $data = $request->only('phase_number', 'title', 'subtitle', 'description', 'topics', 'sort_order');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            if ($phase->image) Storage::disk('public')->delete($phase->image);
            $data['image'] = $request->file('image')->store('training', 'public');
        }

        $phase->update($data);

        return redirect()->route('admin.pages.training')->with('success', 'Phase updated.');
    }

    public function destroyPhase(TrainingPhase $phase)
    {
        if ($phase->image) Storage::disk('public')->delete($phase->image);
        $phase->delete();
        return redirect()->route('admin.pages.training')->with('success', 'Phase deleted.');
    }

    public function togglePhase(TrainingPhase $phase)
    {
        $phase->update(['is_active' => !$phase->is_active]);
        return redirect()->back()->with('success', 'Phase visibility updated.');
    }

    // ── Who For ──────────────────────────────────────────────────────────────

    public function storeWhoFor(Request $request)
    {
        $request->validate([
            'label'      => 'required|string|max:150',
            'sort_order' => 'nullable|integer',
        ]);

        TrainingWhoFor::create([
            'label'      => $request->label,
            'sort_order' => $request->sort_order ?? 0,
            'is_active'  => true,
        ]);

        return redirect()->route('admin.pages.training')->with('success', 'Audience item added.');
    }

    public function updateWhoFor(Request $request, TrainingWhoFor $whoFor)
    {
        $request->validate([
            'label'      => 'required|string|max:150',
            'sort_order' => 'nullable|integer',
        ]);

        $whoFor->update([
            'label'      => $request->label,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.pages.training')->with('success', 'Audience item updated.');
    }

    public function destroyWhoFor(TrainingWhoFor $whoFor)
    {
        $whoFor->delete();
        return redirect()->route('admin.pages.training')->with('success', 'Audience item deleted.');
    }

    public function toggleWhoFor(TrainingWhoFor $whoFor)
    {
        $whoFor->update(['is_active' => !$whoFor->is_active]);
        return redirect()->back()->with('success', 'Visibility updated.');
    }

    // ── Learn Points ─────────────────────────────────────────────────────────

    public function storeLearnPoint(Request $request)
    {
        $request->validate([
            'text'       => 'required|string|max:200',
            'sort_order' => 'nullable|integer',
        ]);

        TrainingLearnPoint::create([
            'text'       => $request->text,
            'sort_order' => $request->sort_order ?? 0,
            'is_active'  => true,
        ]);

        return redirect()->route('admin.pages.training')->with('success', 'Learning point added.');
    }

    public function updateLearnPoint(Request $request, TrainingLearnPoint $learnPoint)
    {
        $request->validate([
            'text'       => 'required|string|max:200',
            'sort_order' => 'nullable|integer',
        ]);

        $learnPoint->update([
            'text'       => $request->text,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.pages.training')->with('success', 'Learning point updated.');
    }

    public function destroyLearnPoint(TrainingLearnPoint $learnPoint)
    {
        $learnPoint->delete();
        return redirect()->route('admin.pages.training')->with('success', 'Learning point deleted.');
    }

    public function toggleLearnPoint(TrainingLearnPoint $learnPoint)
    {
        $learnPoint->update(['is_active' => !$learnPoint->is_active]);
        return redirect()->back()->with('success', 'Visibility updated.');
    }

    // ── Gain Items ───────────────────────────────────────────────────────────

    public function storeGainItem(Request $request)
    {
        $request->validate([
            'icon'       => 'required|string|max:50',
            'title'      => 'required|string|max:100',
            'body'       => 'required|string|max:500',
            'sort_order' => 'nullable|integer',
        ]);

        TrainingGainItem::create([
            'icon'       => $request->icon,
            'title'      => $request->title,
            'body'       => $request->body,
            'sort_order' => $request->sort_order ?? 0,
            'is_active'  => true,
        ]);

        return redirect()->route('admin.pages.training')->with('success', 'Gain item added.');
    }

    public function updateGainItem(Request $request, TrainingGainItem $gainItem)
    {
        $request->validate([
            'icon'       => 'required|string|max:50',
            'title'      => 'required|string|max:100',
            'body'       => 'required|string|max:500',
            'sort_order' => 'nullable|integer',
        ]);

        $data = $request->only('icon', 'title', 'body', 'sort_order');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $gainItem->update($data);

        return redirect()->route('admin.pages.training')->with('success', 'Gain item updated.');
    }

    public function destroyGainItem(TrainingGainItem $gainItem)
    {
        $gainItem->delete();
        return redirect()->route('admin.pages.training')->with('success', 'Gain item deleted.');
    }

    public function toggleGainItem(TrainingGainItem $gainItem)
    {
        $gainItem->update(['is_active' => !$gainItem->is_active]);
        return redirect()->back()->with('success', 'Visibility updated.');
    }
}
