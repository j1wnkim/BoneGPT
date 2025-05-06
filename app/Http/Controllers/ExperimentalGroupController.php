<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Study;
use App\Models\ExperimentalGroup;
use App\Services\ExperimentalGroupService;
use App\Http\Requests\AddExperimentalGroupRequest;

class ExperimentalGroupController extends Controller
{
	private ExperimentalGroupService $experimentalGroupService;

	public function __construct(ExperimentalGroupService $experimentalGroupService)
	{
		$this->experimentalGroupService = $experimentalGroupService;
	}

    public function show($study)
    {
        $groups = $study;
        $studyInfo = $this->getStudyInfo($study);
        
        return view('study.experimental-groups', compact('study', 'groups', 'studyInfo'));
    }

	// TODO: Look at how this function works. There might be a better way to do this
	// TODO: Make this grab all appropriate data from the study
	private function getStudyInfo($study)
    {
        $studyInfo = [
            'types' => [],
            'genotypes' => [],
            'gene_symbols' => [],
            'animal_strains' => [],
            'cre_line_options' => [],
            'drug_induction_options' => []
        ];
    }
}