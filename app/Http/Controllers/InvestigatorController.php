<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Study;

class InvestigatorController extends Controller
{
    public function show($studyId)
    {
        // Optionally retrieve investigators from session or set empty array if none.
        $investigators = session("study_{$studyId}_investigators", []);

        // Simulated "study" array just to pass to the view.
        $study = [
            'id' => $studyId,
            'investigators' => $investigators
        ];

        $countries = [
            (object) ['code' => 'US', 'name' => 'United States'],
            (object) ['code' => 'CA', 'name' => 'Canada'],
            (object) ['code' => 'GB', 'name' => 'United Kingdom'],
        ];

        return view('study.investigators', compact('study', 'countries', 'investigators'));
    }

    public function store(Request $request, $studyId)
    {
        $investigators = $request->input('investigators', []);

        if (empty($investigators)) {
            return back()->withErrors(['error' => 'At least one investigator must be added.']);
        }

        // Store investigators in session (instead of database).
        session()->put("study_{$studyId}_investigators", $investigators);

        return redirect()->route('study.investigators', ['study' => $studyId])
            ->with('success', 'Investigators saved successfully (no database interaction).');
    }
}
