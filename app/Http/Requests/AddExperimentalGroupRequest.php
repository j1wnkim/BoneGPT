<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class AddExperimentalGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sex' => 'required|string',
            'age' => 'required|numeric|min:0|max:9999',
            'strain' => $this->study->strains()->count() > 1 ? 'required|string' : 'nullable',
            'gm_gko_genotype' => $this->study->gm_global_knockout ? 'required|string' : 'nullable',
            'gm_gko_genotype_2' => $this->study->gm_global_knockout && $this->study->gm_gko_has_second_animal_line ? 'required|string' : 'nullable',
            'gm_ind_mutation_genotype' => $this->study->gm_induced_mutation ? 'required|string' : 'nullable',
            'gm_ins_mutagenesis_genotype' => $this->study->gm_insertional_mutagenesis ? 'required|string' : 'nullable',
        ];
    }


    public function after() : array
    {
        return [
            function (Validator $validator) {
                if ( $this->study->gm_global_knockout && !$this->study->gm_gko_gene_symbol ) {
                    $validator->errors()->add('gm_gko_gene_symbol', 'Gene symbol is required for global knockout studies, and must be filled out on the Animal Experimentation page.');

                    if ( $this->study->gm_gko_has_second_animal_line && !$this->study->gm_gko_gene_symbol_2 ) {
                        $validator->errors()->add('gm_gko_gene_symbol_2', 'Gene symbol is required for second animal line in global knockout studies, and must be filled out on the Animal Experimentation page.');
                    }
                }


                if ( $this->study->gm_induced_mutation && !$this->study->gm_ind_mutation_gene_symbol ) {
                    $validator->errors()->add('gm_ind_mutation_gene_symbol', 'Gene symbol is required for induced mutation studies, and must be filled out on the Animal Experimentation page.');
                }

                if ( $this->study->gm_insertional_mutagenesis && !$this->study->gm_ins_mutagenesis_gene_symbol ) {
                    $validator->errors()->add('gm_ins_mutagenesis_gene_symbol', 'Gene symbol is required for insertional mutagenesis studies, and must be filled out on the Animal Experimentation page.');
                }
            }
        ];
    }
}