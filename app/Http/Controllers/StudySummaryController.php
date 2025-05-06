<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Study;

class StudySummaryController extends Controller
{
    public function show($study)
    {
        // Eager load relationships to avoid N+1 queries
        // $study->load([
        //     'investigators',
        //     'experimentalGroups',
        //     'uploads.samples.experimentalGroup',
        // ]);

        return view('study.summary', compact('study'));
    }
}