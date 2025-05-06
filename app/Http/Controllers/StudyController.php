<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Study;

class StudyController extends Controller
{

    public function store(Request $request) {
        // Simulate the creation of a new study by storing in the session
        $study = [
            'id' => uniqid(), // Generate a unique identifier
            'status' => 'New',
            'user_id' => auth()->id(),
            'created_at' => now(),
        ];

        // Store the study in the session
        session()->put('study', $study);

        return redirect()->route('study.study-information', ['study' => $study['id']]);
    }

	public function showInformation($studyId) {
        // Retrieve the study from the session
        $study = session('study');

        // If the study doesn't exist in the session, show an error
        // if (!$study || $study['id'] !== $studyId) {
        //     return redirect()->route('study')->with('error', 'Study not found.');
        // }

        // Return the view with the study data
        return view('study.study-information', compact('study'));
    }

    // Store the study information (for updating) in the session instead of the database
    public function storeInformation(Request $request, $studyId) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string',
            'funding_sources' => 'nullable|string',
            'conflicts' => 'nullable|string',
            'completion_date' => 'required|date',
            'is_published' => 'required|boolean',
            'doi' => 'nullable|string|required_if:is_published,1',
            'pubmed_id' => 'nullable|string|required_if:is_published,1',
            'publication_plan' => 'nullable|string|required_if:is_published,0',
            'embargo_months' => 'nullable|integer|min:0|required_if:publication_plan,different_journal',
        ], [
            'is_published.required' => 'Please indicate whether the study has been published.',
            'publication_plan.required_if' => 'Please select a publication plan.',
        ]);

        // Retrieve the study from the session
        $study = session('study');

        // If the study doesn't exist in the session or the IDs don't match, show an error
        if (!$study || $study['id'] !== $studyId) {
            return redirect()->route('study.index')->with('error', 'Study not found.');
        }

        // Update the study in the session with the new information
        $study['title'] = $validated['title'];
        $study['summary'] = $validated['summary'];
        $study['funding_sources'] = $validated['funding_sources'];
        $study['conflicts'] = $validated['conflicts'];
        $study['completion_date'] = $validated['completion_date'];
        $study['is_published'] = $validated['is_published'];
        $study['doi'] = $validated['doi'] ?? null;
        $study['pubmed_id'] = $validated['pubmed_id'] ?? null;
        $study['publication_plan'] = $validated['is_published'] ? null : ($validated['publication_plan'] ?? null);
        $study['embargo_months'] = $validated['is_published'] ? null : ($validated['embargo_months'] ?? null);

        // Store the updated study back into the session
        session()->put('study', $study);

        return redirect()->route('study.study-information', ['study' => $studyId])->with('success', 'Study information updated successfully.');
    }

    // Display all stored studies (if any)
    public function showStudies(Request $request) {
        // Retrieve all studies from session (in this case, assuming we only have one study)
        $studies = session('studies', []);

        return view('admin.studies', compact('studies'));
    }


    public function showInvestigators($studyId)
    {
        $study = Study::findOrFail($studyId);

        // Define the countries array
        $countries = [
            (object) ['code' => 'US', 'name' => 'United States'],
            (object) ['code' => 'CA', 'name' => 'Canada'],
            (object) ['code' => 'GB', 'name' => 'United Kingdom'],
        ];

        return view('study.investigators', compact('study', 'countries'));
    }

        public function getStudyData()
    {
        // Log the start of the method
        Log::info('getStudyData method called.');

        // Get the path to the JSON file
        $filePath = public_path('output_answer.json');
        Log::info('File path resolved:', ['filePath' => $filePath]);

        // Check if the file exists
        if (file_exists($filePath)) {
            Log::info('File exists at the specified path.');

            // Read the file contents
            $jsonContent = file_get_contents($filePath);
            Log::info('File contents read successfully.', ['jsonContent' => $jsonContent]);

            // Return the content as a JSON response
            return response()->json(json_decode($jsonContent));
        } else {
            Log::error('File not found at the specified path.', ['filePath' => $filePath]);

            // If the file doesn't exist, return an error response
            return response()->json(['error' => 'File not found'], 404);
        }
    }


}
