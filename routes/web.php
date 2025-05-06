<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use App\Http\Controllers\PublicController;
use App\Http\Controllers\DataController;

use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\StudyMockController;
use App\Http\Controllers\NewChartController;
use App\Http\Controllers\AnimalExperimentationController;
use App\Http\Controllers\PhenotypeAnalysisController;
use App\Http\Controllers\ExperimentalGroupController;
use App\Http\Controllers\StudyController;
use App\Http\Controllers\StudySummaryController;
use App\Http\Controllers\InvestigatorController;
use App\Http\Controllers\SubjectAreasController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CoreFacilityController;
use App\Http\Controllers\TeamPageController;
use App\Http\Middleware\CasAuthMiddleware;
use App\Http\Controllers\CasAuthController;

Route::get('/OG', [ChatbotController::class, 'index']); 

Route::get('/', [PublicController::class, 'home'])->name('home');

Route::get('/data-submission', [PublicController::class, 'dataSubmission'])->name('data-submission');

Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
Route::post('/contact', [PublicController::class, 'submitContact'])->name('contact.submit');

Route::get('/team', [TeamPageController::class, 'index'])->name('team');
Route::get('/terms-of-use', function () {return view('about.terms-of-use');})->name('about.terms-of-use');

// Core Facility routes
Route::get('/core-facility', [CoreFacilityController::class, 'index'])->name('core-facility.index');
Route::post('/core-facility', [CoreFacilityController::class, 'store'])->name('core-facility.store');
Route::get('/core-facility/create', [CoreFacilityController::class, 'create'])->name('core-facility.create');

// This route should handle the message submission (POST request)
Route::post('/', [ChatbotController::class, 'storeInput']);

Route::get('/chart', [ChartController::class, 'index']);
Route::get('/chart/gene-info/{gene}', [ChartController::class, 'getGeneInfo']);
Route::get('/new-chart', [NewChartController::class, 'index']);
Route::get('/new-chart/gene-info/{gene}', [NewChartController::class, 'getGeneInfo']);

Route::get('/study-mock', [StudyMockController::class, 'showForm']);  // Route to show the form
Route::post('/study-mock', [StudyMockController::class, 'submitForm']);  // Route to handle the form submission

// Study routes
Route::post('/study', [StudyController::class, 'store'])->name('study.store');

// Study Information routes
Route::get('/study/{study}/study-information', [StudyController::class, 'showInformation'])->name('study.study-information');
Route::post('/study/{study}/study-information', [StudyController::class, 'storeInformation'])->name('study.study-information.store');

// Subject Areas routes
Route::get('/study/{study}/subject-areas', [SubjectAreasController::class, 'show'])->name('study.subject-areas');
Route::post('/study/{study}/subject-areas', [SubjectAreasController::class, 'store'])->name('study.subject-areas.store');

// Investigator routes
Route::get('/study/{study}/investigators', [InvestigatorController::class, 'show'])->name('study.investigators');
Route::post('/study/{study}/investigators', [InvestigatorController::class, 'store'])->name('study.save-investigators');

// Animal Experimentation routes
Route::get('/study/{study}/animal-experimentation', [AnimalExperimentationController::class, 'show'])->name('study.animal-experimentation');
Route::post('/study/{study}/animal-experimentation', [AnimalExperimentationController::class, 'store'])->name('study.save-animal-experimentation');

// Experimental Groups routes
Route::get('/study/{study}/experimental-groups', [ExperimentalGroupController::class, 'show'])->name('study.experimental-groups');
Route::post('/study/{study}/experimental-groups', [ExperimentalGroupController::class, 'store'])->name('study.save-experimental-groups');
Route::post('/study/{study}/experimental-groups/add', [ExperimentalGroupController::class, 'addGroup'])->name('study.add-experimental-group');
Route::delete('/study/{study}/experimental-groups/delete', [ExperimentalGroupController::class, 'removeGroup'])->name('study.delete-experimental-group');

// Phenotype Analysis routes
Route::get('/study/{study}/phenotype-analysis', [PhenotypeAnalysisController::class, 'show'])->name('study.phenotype-analysis');
Route::post('/study/{study}/phenotype-analysis', [PhenotypeAnalysisController::class, 'store'])->name('study.save-phenotype-analysis');

// Summary routes
// Route::get('/study/{study}/summary', function ($study) {
//     return view('study-summary');
// })->name('study.summary');

Route::get('/study/{study}/summary', [StudySummaryController::class, 'show'])->name('study.summary');

Route::post('/save-columns', [DataController::class, 'saveColumns']);

// Setting routes
Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
Route::post('/settings/select-llm', [SettingsController::class, 'selectLLM'])->name('settings.select-llm');

Route::get('/login', [AuthController::class, 'show_login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/tables', [DataController::class, 'index']);
Route::get('/tables/data/{tableName}', [DataController::class, 'getTableData']);
Route::get('/tables/columns/{tableName}', [DataController::class, 'getTableColumns']);

Route::get('/switch-database/{database}', [DataController::class, 'switchDatabase']);

// register routes
Route::middleware(['guest'])->group(function () {
    
    Route::get('/register', [AuthController::class, 'show_register'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    Route::get('/forgot-password', [AuthController::class, 'show_forgot_password'])->name('forgot-password');
    Route::post('/forgot-password', [AuthController::class, 'forgot_password'])->name('forgot-password');

    Route::get('/reset-password/{token}', [AuthController::class, 'show_reset_password'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'reset_password'])->name('reset-password');
});

Route::post('/log-js-error', function (Illuminate\Http\Request $request) {
    $errorMessage = $request->input('message', 'No error message provided');
    $errorDetails = $request->input('details', []);
    Log::error('JavaScript Error Logged:', ['message' => $errorMessage, 'details' => $errorDetails]);
    return response()->json(['message' => 'Error logged successfully']);
});


// Normal login
Route::get('/login', function () {
    return view('auth.login'); // Replace with your login view
})->name('login');

// CAS login
Route::get('/cas-login', [CasAuthController::class, 'login'])->name('cas.login');
Route::get('/cas-logout', [CasAuthController::class, 'logout'])->name('cas.logout');

// Protect routes with CAS authentication
Route::middleware(['cas.auth'])->group(function () {
    Route::get('/dashboard', function () {
        return 'Welcome to the dashboard!';
    })->name('dashboard');
});
// applying middleware for CAS
Route::get('/dashboard', function () {
    return 'Welcome to the dashboard!';
})->middleware(CasAuthMiddleware::class);

// Dashboard Route
Route::get('/dashboard', function () {
    return view('dashboard'); // Replace with your dashboard view
});

// Gene Summary Route
Route::get('/gene-summary', function () {
    return view('gene-summary');
})->name('gene.summary');

Route::get('/study-data', [StudyController::class,'getStudyData']);

Route::get('/highlight-data', [DataController::class,'getStudyData']);

Route::get('/study/{study}/rag', function () {
    return view('rag');
})->name('rag.summary');




Route::get('/test-database/{database}', function ($database) {
    try {
        // Dynamically switch the database
        config(['database.connections.pgsql.database' => $database]);
        DB::purge('pgsql');
        DB::reconnect('pgsql');

        // Test the connection and fetch tables
        $tables = DB::select("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");
        $tableNames = array_map('current', $tables);

        return response()->json([
            'success' => true,
            'message' => 'Connected to database successfully!',
            'tables' => $tableNames,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to connect to database: ' . $e->getMessage(),
        ], 500);
    }
});

Route::post('/log', function (Request $request) {
    $message = $request->input('message', 'No message provided');
    $level = $request->input('level', 'info'); // Default to 'info' level
    $details = $request->input('details', null);

    // Log the message with the specified level
    if ($details) {
        Log::{$level}($message, ['details' => $details]);
    } else {
        Log::{$level}($message);
    }

    return response()->json(['status' => 'logged']);
});

Route::post('/log-error', function (Illuminate\Http\Request $request) {
    $errorDetails = $request->input('error', []);
    $context = [
        'user_id' => auth()->check() ? auth()->id() : null,
        'url' => $request->headers->get('referer'),
        'ip_address' => $request->ip(),
        'timestamp' => now()->toDateTimeString(),
        'error_details' => $errorDetails,
    ];
    Log::error($request->input('message', 'Unknown error'), $context);
    return response()->json(['status' => 'logged'], 200);
});

Route::post('/log-js-event', function (\Illuminate\Http\Request $request) {
    Log::info('JavaScript Event Log:', $request->all());
    return response()->json(['message' => 'Log received'], 200);
});


