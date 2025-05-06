<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    // Display the settings page
    public function index()
    {
        // Pass available LLMs to the view
        $llms = ['ChatGPT', 'GPT-4', 'Claude', 'Custom LLM']; // Replace with your actual LLM options
        return view('settings', compact('llms'));
    }

    // Handle LLM selection
    public function selectLLM(Request $request)
    {
        $selectedLLM = $request->input('llm');
        
        // Save the selected LLM to the session or database
        session(['selected_llm' => $selectedLLM]);

        return redirect()->back()->with('success', 'LLM selection updated!');
    }
}