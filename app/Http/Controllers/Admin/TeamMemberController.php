<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamMemberController extends Controller
{
    public function index()
    {
        $members = TeamMember::orderBy('sort_order')->orderBy('name')->get();
        return view('admin.team.index', compact('members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:100',
            'role'       => 'required|string|max:100',
            'bio'        => 'nullable|string|max:600',
            'sort_order' => 'nullable|integer',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $validated['is_active'] = true;
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('team', 'public');
        }

        TeamMember::create($validated);

        return redirect()->route('admin.team')->with('success', 'Team member added.');
    }

    public function update(Request $request, TeamMember $team)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:100',
            'role'         => 'required|string|max:100',
            'bio'          => 'nullable|string|max:600',
            'sort_order'   => 'nullable|integer',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'remove_image' => 'nullable|boolean',
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            if ($team->image) Storage::disk('public')->delete($team->image);
            $validated['image'] = $request->file('image')->store('team', 'public');
        } elseif ($request->boolean('remove_image')) {
            if ($team->image) Storage::disk('public')->delete($team->image);
            $validated['image'] = null;
        }

        unset($validated['remove_image']);
        $team->update($validated);

        return redirect()->route('admin.team')->with('success', 'Team member updated.');
    }

    public function destroy(TeamMember $team)
    {
        if ($team->image) Storage::disk('public')->delete($team->image);
        $team->delete();
        return redirect()->route('admin.team')->with('success', 'Team member removed.');
    }

    public function toggleActive(TeamMember $team)
    {
        $team->update(['is_active' => !$team->is_active]);
        return redirect()->back()->with('success', 'Visibility updated.');
    }
}
