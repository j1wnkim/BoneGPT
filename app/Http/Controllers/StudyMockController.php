<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudyMockController extends Controller
{
    // Show the study information form
    public function showForm()
    {
        return view('study');
    }

    // Handle the form submission
    public function submitForm(Request $request)
    {
        // Validate input data
        $request->validate([
            'study-title' => 'required|string|max:255',
            'study-summary' => 'required|string',
        ]);

        // Here you would save the data to the database or process it
        // For now, we are just returning the data
        $data = $request->only(['study-title', 'study-summary']);

        // For simplicity, we'll just return the submitted data
        return view('study-result', compact('data'));
    }
}
