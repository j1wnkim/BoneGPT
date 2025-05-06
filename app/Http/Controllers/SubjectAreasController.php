<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Study;

class SubjectAreasController extends Controller
{
    public function show($studyId)
    {
        // Example: Simulate study data, since we're not querying DB.
        $study = [
            'id' => $studyId,
            'subject_areas' => [] // Placeholder if you want to prefill.
        ];

        return view('study.subject-areas', compact('study'));
    }

    public function store(Request $request, $studyId)
    {
        $data = $request->validate([
            'subject_areas' => 'nullable|array',
            'subject_areas.*' => 'string'
        ]);

        if (!isset($data['subject_areas'])) {
            $data['subject_areas'] = [];
        }

        // Normally you'd update the database here, but instead you could:
        // - Store in session
        // - Log it
        // - Forward it to another service

        // Example: Storing in session (optional)
        session()->put("study_{$studyId}_subject_areas", $data['subject_areas']);

        return redirect()->route('study.subject-areas', ['study' => $studyId])
            ->with('success', 'Subject areas received (no database update).');
    }
}