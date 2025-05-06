<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CoreFacility;
class CoreFacilityController extends Controller
{
    public function index()
    {
        $coreFacilities = CoreFacility::all();
        return view('core-facility.index', compact('coreFacilities'));
    }

	public function create()
	{
		return view('core-facility.create');
	}
	
	public function store(Request $request)
	{
		$validated = $request->validate([
			'facility_name' => 'required|string|max:255',
			'web_address' => 'required|url|max:255',
			'institution' => 'required|string|max:255',
			'contact_name' => 'required|string|max:255',
			'contact_email' => 'required|email|max:255',
			'analysis_types' => 'required|array',
		]);

		CoreFacility::create($validated);

		return redirect()->route('core-facility.index')->with('success', 'Core facility added successfully');
	}
}