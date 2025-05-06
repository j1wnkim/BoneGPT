<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Investigator;
use App\Models\Study;
use App\Services\InvestigatorService;
use App\Models\Country;

class InvestigatorForm extends Component
{
	private InvestigatorService $investigatorService;
    public $study;
    public $investigators;
	public $states;
    public $countries;
    public $newInvestigator = [
        'first_name' => '',
        'last_name' => '',
        'email' => '',
        'department' => '',
        'organization' => '',
        'country' => '',
        'state' => '',
        'is_corresponding' => false
    ];

    protected $rules = [
        'newInvestigator.first_name' => 'required',
        'newInvestigator.last_name' => 'required',
        'newInvestigator.email' => 'required|email',
        'newInvestigator.department' => 'required',
        'newInvestigator.organization' => 'required',
        'newInvestigator.country' => 'required',
        'newInvestigator.state' => 'required_if:newInvestigator.country,US',
        'newInvestigator.is_corresponding' => 'boolean'
    ];

	public function __construct()
	{
		$this->investigatorService = new InvestigatorService();
	}

    public function mount(Study $study)
    {
        $this->study = $study;
        $this->investigators = $study->investigators;
		$this->states = $this->investigatorService->getStates();
        $this->countries = Country::all();
    }

    public function addInvestigator()
    {
        $this->validate();

        $this->study->investigators()->create($this->newInvestigator);

        $this->newInvestigator = [
            'first_name' => '',
            'last_name' => '',
            'email' => '',
            'department' => '',
            'organization' => '',
            'country' => '',
            'state' => '',
            'is_corresponding' => false
        ];

        $this->investigators = $this->study->fresh()->investigators;
        session()->flash('success', 'Investigator added successfully.');
    }

    public function removeInvestigator($id)
    {
        $this->study->investigators()->where('id', $id)->delete();
        $this->investigators = $this->study->fresh()->investigators;
        session()->flash('success', 'Investigator removed successfully.');
    }

    public function render()
    {
        return view('livewire.investigator-form');
    }
}