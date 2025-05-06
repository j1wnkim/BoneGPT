<?php

namespace App\Services;

use App\Models\Study;
use App\Models\ExperimentalGroup;
class ExperimentalGroupService
{
    public function createGroupName(Study $study, array $groupData)
    {
        $parts = collect();

        if ( $study->gm_global_knockout ) {
            $parts->push($study->gm_gko_gene_symbol);
            $parts->push($groupData['gm_gko_genotype']);

            if ($study->gm_gko_has_second_animal_line) {
                $parts->push($study->gm_gko_gene_symbol_2);
                $parts->push($groupData['gm_gko_genotype_2']);
            }
        }

        if ( $study->gm_induced_mutation ) {
            $parts->push($study->gm_ind_mutation_gene_symbol);
            $parts->push($groupData['gm_ind_mutation_genotype']);
        }

        if ( $study->gm_insertional_mutagenesis ) {
            $parts->push($study->gm_ins_mutagenesis_gene_symbol);
            $parts->push($groupData['gm_ins_mutagenesis_genotype']);
        }

        if ( !empty($groupData['strain']) ) {
            $parts->push($groupData['strain']);
        }

        $parts->push(match($groupData['sex']) {
            'male' => 'M',
            'female' => 'F',
            default => ''
        });
        $parts->push($groupData['age'] . 'wk');

        return $parts->implode('_');
    }


    public function generateGroupName(array $groupData)
    {

        $parts = [];
        
        if (!empty($groupData['sex'])) {
            $parts[] = match($groupData['sex']) {
                'male' => 'M',
                'female' => 'F',
                default => ''
            };
        }
        
        if (!empty($groupData['age'])) {
            $parts[] = $groupData['age'] . 'wk';
        }
        
        if (!empty($groupData['cre_line'])) {
            $parts[] = $groupData['cre_line'];
        }
        
        if (!empty($groupData['drug_treatment'])) {
            $parts[] = $groupData['drug_treatment'];
        }
        
        return implode('_', $parts);
    }

    public function checkForDuplicates(Study $study, array $groupData)
    {
        $exists = ExperimentalGroup::where('study_id', $study->id)
            ->where('gene_symbol', $groupData['gene_symbol'] ?: null)
            ->where('genotype', $groupData['genotype'])
            ->where('sex', $groupData['sex'] ?: null)
            ->where('age', $groupData['age'] ?: null)
            ->where('cre_line', $groupData['cre_line'] ?? null)
            ->where('drug_treatment', $groupData['drug_treatment'] ?? null)
            ->exists();

        return $exists;
    }

	public function generateGenotypeOptions(?string $nomenclature, ?string $customNomenclature = null)
	{
		// Default genotype options
		$genotypeOptions = ['+/+' => 'Wild type (+/+)'];

		// Suffix for genotype options
		$suffix = match($nomenclature) {
			'other' => $customNomenclature,
			'knockout' => '-',
			'wildtype_knockout' => '-',
			'knockin' => 'KI',
			'wildtype_knockin' => 'KI',
			'knockout_knockin' => 'KI',
			'wildtype_knockout_knockin' => 'KI',
			'spontaneous' => 'Sm',
			'chemical' => 'Ci',
			'xray' => 'XR',
			'gene_trap' => 'Gt',
			'enhancer_trap' => 'Et',
			'transponson' => 'Tp',
			'viral' => 'Vi',
			'wild_floxed' => 'flx',
			default => null
		};

		// Add genotype options if suffix is not null
		if ($suffix) {
			$genotypeOptions += [
				"+/$suffix" => "Heterozygous (+/$suffix)",
				"$suffix/$suffix" => "Homozygous ($suffix/$suffix)"
			];
		}

		return $genotypeOptions;
	}
}