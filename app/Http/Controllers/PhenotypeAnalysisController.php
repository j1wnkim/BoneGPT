<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Study;

class PhenotypeAnalysisController extends Controller
{
    public function show($study)
	{
		$uploads = $study;

		return view('study.phenotype-analysis', compact( 'study', 'uploads'));
	}

	public function store(Request $request)
	{
		$study = Study::findOrFail($request->study_id);
		$study->update([
			'dexa' => $request->has('dexa'),
			'micro_ct' => $request->has('micro_ct'),
			'bone_histomorphometry' => $request->has('bone_histomorphometry'),
			'mechanical_testing' => $request->has('mechanical_testing'),
			'clinical_biochemistry' => $request->has('clinical_biochemistry'),
			'dexa_whole_body' => $request->has('dexa_whole_body'),
			'dexa_femur' => $request->has('dexa_femur'),
			'dexa_tibia' => $request->has('dexa_tibia'),
			'dexa_vertebra' => $request->has('dexa_vertebra'),
			'micro_ct_femur_trabecular' => $request->has('micro_ct_femur_trabecular'),
			'micro_ct_femur_cortical' => $request->has('micro_ct_femur_cortical'),
			'micro_ct_tibia_trabecular' => $request->has('micro_ct_tibia_trabecular'),
			'micro_ct_tibia_cortical' => $request->has('micro_ct_tibia_cortical'),
			'micro_ct_vertebra_trabecular' => $request->has('micro_ct_vertebra_trabecular'),
			'bone_histomorphometry_femur_trabecular' => $request->has('bone_histomorphometry_femur_trabecular'),
			'bone_histomorphometry_femur_cortical' => $request->has('bone_histomorphometry_femur_cortical'),
			'bone_histomorphometry_tibia_trabecular' => $request->has('bone_histomorphometry_tibia_trabecular'),
			'bone_histomorphometry_tibia_cortical' => $request->has('bone_histomorphometry_tibia_cortical'),
			'bone_histomorphometry_vertebra_trabecular' => $request->has('bone_histomorphometry_vertebra_trabecular'),
		]);

		return back()->with('success', 'Study updated successfully');
	}
}
