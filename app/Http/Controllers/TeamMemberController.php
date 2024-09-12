<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Storage;

class TeamMemberController extends Controller
{
    public function index()
    {
        $teamMembers = TeamMember::all();
        return view('about.team.index', compact('teamMembers'));
    }

    public function create()
    {
        return view('about.team.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'name_en' => 'nullable|string|max:255',
            'position_en' => 'nullable|string|max:255',
            'description_en' => 'nullable|string',
        ]);

        $teamMember = new TeamMember();
        $teamMember->setTranslations('name', [
            'ka' => $request->input('name'),
            'en' => $request->input('name_en')
        ]);
        $teamMember->setTranslations('position', [
            'ka' => $request->input('position'),
            'en' => $request->input('position_en')
        ]);
        $teamMember->setTranslations('description', [
            'ka' => $request->input('description'),
            'en' => $request->input('description_en')
        ]);

        if ($request->hasFile('photo')) {
            $teamMember->photo = $request->file('photo')->store('team_photos', 'public');
        }

        $teamMember->save();

        return redirect()->route('team.index')->with('success', 'Team member added successfully!');
    }


    public function edit(TeamMember $team)
    {
        return view('about.team.edit', compact('team'));
    }

    public function update(Request $request, TeamMember $team)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'name_en' => 'nullable|string|max:255',
            'position_en' => 'nullable|string|max:255',
            'description_en' => 'nullable|string',
        ]);

        $team->setTranslations('name', [
            'ka' => $request->input('name'),
            'en' => $request->input('name_en')
        ]);
        $team->setTranslations('position', [
            'ka' => $request->input('position'),
            'en' => $request->input('position_en')
        ]);
        $team->setTranslations('description', [
            'ka' => $request->input('description'),
            'en' => $request->input('description_en')
        ]);

        if ($request->hasFile('photo')) {
            if ($team->photo && Storage::exists('public/' . $team->photo)) {
                Storage::delete('public/' . $team->photo);
            }

            $team->photo = $request->file('photo')->store('team_photos', 'public');
        }

        $team->save();

        return redirect()->route('team.index')->with('success', 'Team member updated successfully!');
    }

    public function destroy(TeamMember $team)
    {
        if ($team->photo) {
            Storage::delete('public/' . $team->photo);
        }

        $team->delete();
        return redirect()->route('team.index')->with('success', 'Team member deleted successfully!');
    }
}
