public function index(Request $request)
{
    $selectedDatabase = $request->query('database', 'default'); // Default database if none is selected

    if ($selectedDatabase === 'db2') {
        // Switch to the KOMP220 database
        config(['database.connections.mysql.database' => env('DB_KOMP220_DATABASE')]);
        DB::purge('mysql'); // Clear the current connection
        DB::reconnect('mysql'); // Reconnect with the new configuration
    }

    $tables = DB::select('SHOW TABLES'); // Fetch tables from the selected database
    return view('dashboard', ['tables' => $tables]);
}
