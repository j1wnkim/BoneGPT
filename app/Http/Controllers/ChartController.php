<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TFList;

class ChartController extends Controller
{
    public function index()
{
    // Fetch data from the 'tf_list' table
    $data = TFList::all();

    // Extract gene symbols and map them to their details
    $geneSymbols = $data->pluck('gene')->unique();
    $geneDetails = [];

    foreach ($data as $item) {
        $geneDetails[$item->gene] = [
            'DBD' => $item->DBD,
            'Motif status' => $item->{'Motif status (Feb 2018)'},
            'IUPAC Consensus' => $item->{'IUPAC Consensus'}
        ];
    }

    // Pass data to the view
    return view('chart', compact('geneSymbols', 'geneDetails'));
}

    public function getGeneInfo($gene)
    {
        $geneInfo = TFList::where('gene', $gene)->first();

        if ($geneInfo) {
            return response()->json([
                'ID' => $geneInfo->ID,
                'DBD' => $geneInfo->DBD,
                'MotifStatus' => $geneInfo->{'Motif status (Feb 2018)'},
                'IUPACConsensus' => $geneInfo->{'IUPAC Consensus'}
            ]);
        }

        return response()->json(['error' => 'Gene not found'], 404);
    }
}
