<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TFList;

class NewChartController extends Controller
{
    public function index()
    {
        // Use the new database connection
        $data = DB::connection('sqlsrv')->table('tf_list')->get();

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
        return view('new_chart', compact('geneSymbols', 'geneDetails'));
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