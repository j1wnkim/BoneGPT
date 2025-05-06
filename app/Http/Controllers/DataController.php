<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class DataController extends Controller
{
    // private $allowedTables = [
    //     'Control_female_Cortical_average',
    //     'Control_male_Cortical_average',
    //     'Controlfemale_femurCorticalIM',
    //     'Controlmale_femurCorticalIM',
    //     'controlfemale_Vertebra',
    //     'controlfemale_femur',
    //     'controlmale_Vertebra',
    //     'controlmale_femur',
    //     'femaleVertebraIM',
    //     'female_FemurCortical_average',
    //     'female_Femur_average',
    //     'female_Vert_average',
    //     'female_femurCorticalIM',
    //     'female_femurIM',
    //     'maleVertebraIM',
    //     'male_FemurCortical_average',
    //     'male_Femur_average',
    //     'male_Vert_average',
    //     'male_femurCorticalIM',
    //     'male_femurIM',
    //     'HistoControlfemale_Femur_average',

    // ];

    public function index()
    {
        // return view('dashboard', ['tables' => $this->allowedTables]);
         // Fetch tables from the database
        $tables = DB::select("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");
        $tableNames = array_map('current', $tables); // Extract table names

        // Pass the tables to the view
        return view('dashboard', ['tables' => $tableNames]);
        // return view('dashboard');
    }

    public function getTableData($tableName)
    {
        // if (!in_array($tableName, $this->allowedTables)) {
        //     return response()->json(['error' => 'Invalid table'], 404);
        // }

        $data = DB::table($tableName)->get();
        return response()->json($data);
    }

    public function getTableColumns($tableName)
    {
        Log::info("Fetching columns for table: $tableName");
        try {
            $columns = DB::select("SELECT column_name FROM information_schema.columns WHERE table_name = ?", [$tableName]);
            return response()->json(array_map('current', $columns));
        } catch (\Exception $e) {
            Log::error("Error fetching columns for table: $tableName", ['exception' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid table'], 404);
        }
    }

    public function getTables(Request $request)
    {
        $selectedDatabase = $request->query('database', 'default'); // Default database if none is selected

        if ($selectedDatabase === 'db2') {
            // Switch to the KOMP220 database
            config(['database.connections.mysql.database' => env('DB_KOMP220_DATABASE')]);
            DB::purge('mysql'); // Clear the current connection
            DB::reconnect('mysql'); // Reconnect with the new configuration
        }

        $tables = DB::select('SHOW TABLES'); // Fetch tables from the selected database
        return response()->json($tables); // Return tables as JSON
    }

    public function switchDatabase($database)
    {
        Log::info("Switching to database: $database");
        try {
            config(['database.connections.pgsql.database' => $database]);
            DB::purge('pgsql');
            DB::reconnect('pgsql');
            $tables = DB::select("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");
            return response()->json(array_map('current', $tables));
        } catch (\Exception $e) {
            Log::error("Error switching database: $database", ['exception' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to switch database'], 500);
        }
    }

    public function getStudyData()
    {
        // Log the start of the method
        Log::info('getStudyData method called.');

        // Get the path to the JSON file
        $filePath = public_path('update_graph.json');
        Log::info('File path resolved:', ['filePath' => $filePath]);

        // Check if the file exists
        if (file_exists($filePath)) {
            Log::info('File exists at the specified path.');

            // Read the file contents
            $jsonContent = file_get_contents($filePath);
            Log::info('File contents read successfully.', ['jsonContent' => $jsonContent]);

            $decodedContent = json_decode($jsonContent, true);

            $responseContent = [
                'points' => $decodedContent['sampleName'] ?? []
            ];
    

            // Return the content as a JSON response
            return response()->json($responseContent);
        } else {
            Log::error('File not found at the specified path.', ['filePath' => $filePath]);

            // If the file doesn't exist, return an error response
            return response()->json(['error' => 'File not found'], 404);
        }
    }

    public function saveColumns(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'databaseName' => 'required|string',
            'tableName' => 'required|string',
            'xAxisColumn' => 'required|string',
            'yAxisColumn' => 'required|string',
        ]);

        // Prepare the data to write to the file
        $data = [
            'databaseName' => $validated['databaseName'],
            'tableName' => $validated['tableName'],
            'xAxisColumn' => $validated['xAxisColumn'],
            'yAxisColumn' => $validated['yAxisColumn'],
        ];

        // Convert the data to JSON format
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);

        // Write the data to a file in the storage directory
        $filePath = public_path('columns.json'); // File will be saved in storage/app/colum
        file_put_contents($filePath, $jsonData);

        return response()->json(['message' => 'Data saved successfully!', 'filePath' => $filePath]);
    }
}
