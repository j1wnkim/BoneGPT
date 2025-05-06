<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;

class ExperimentalGroup extends Model
{
    use HasFactory;

	protected $guarded = [];

	public function study() {
		return $this->belongsTo(Study::class);
	}

	public static function getDisplayableFields()
	{
		return [
			'group_name' => 'Group Name',
			'gene_symbol' => 'Gene Symbol',
			'genotype' => 'Genotype',
			'strain' => 'Strain',
			'sex' => 'Sex',
			'age' => 'Age',
			'cre_line' => 'Cre Line',
			'drug_treatment' => 'Drug Treatment',
		];
	}

	public static function getPopulatedFields($groups)
	{
		$fields = self::getDisplayableFields();
		return collect($fields)->filter(function ($label, $field) use ($groups) {
			return $groups->contains(function ($group) use ($field) {
				return !empty($group->{$field});
			});
		});
	}


	public function getGroupNameHtml() {
		// Sorry this is going here but rendering blade removing whitespace only between content/tags is weird to maintain.
		$html = '<span class="experimental-group-name">';
		if ( $this->study->gm_global_knockout ) {
			$html .= '<span class="gm_gko_gene_symbol">' . $this->gm_gko_gene_symbol . '</span><sup class="gm_gko_genotype">' . $this->gm_gko_genotype . '</sup>';
			if ( $this->gm_gko_gene_symbol_2 ) {
				$html .= '_<span class="gm_gko_gene_symbol">' . $this->gm_gko_gene_symbol_2 . '</span><sup class="gm_gko_genotype">' . $this->gm_gko_genotype_2 . '</sup>';
			}
		}

		if ( $this->study->gm_induced_mutation ) {
			$html .= '_<span class="gm_ind_mutation_gene_symbol">' . $this->gm_ind_mutation_gene_symbol . '</span><sup class="gm_ind_mutation_genotype">' . $this->gm_ind_mutation_genotype . '</sup>';
		}

		if ( $this->study->gm_insertional_mutagenesis ) {
			$html .= '_<span class="gm_ins_mutagenesis_gene_symbol">' . $this->gm_ins_mutagenesis_gene_symbol . '</span><sup class="gm_ins_mutagenesis_genotype">' . $this->gm_ins_mutagenesis_genotype . '</sup>';
		}

		if ( !empty($this->strain) ) {
			$html .= '_<span class="strain">' . $this->strain . '</span>';
		}

		$html .= '_<span class="sex">' . match($this->sex) {
			'male' => 'M',
			'female' => 'F',
			default => ''
		} . '</span>';

		$html .= '_<span class="age">' . $this->age . 'wk</span>';

		$html .= '</span>';
		return $html;
	}
}