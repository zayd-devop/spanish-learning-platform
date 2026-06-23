<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeekController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Resume Routes
    Route::get('/resumes', [App\Http\Controllers\ResumeController::class, 'index']);
    Route::post('/resumes', [App\Http\Controllers\ResumeController::class, 'store']);
    Route::get('/resumes/{id}', [App\Http\Controllers\ResumeController::class, 'show']);
});

// AI Routes
Route::post('/ai/enhance', [App\Http\Controllers\AiController::class, 'enhanceText']);
Route::post('/ai/analyze-cv', [App\Http\Controllers\AiController::class, 'analyzeCv']);
Route::post('/ai/extract-pdf', [App\Http\Controllers\AiController::class, 'extractPdfText']);
Route::post('/ai/parse-resume-pdf', [App\Http\Controllers\AiController::class, 'parseResumePdf']);
Route::post('/ai/chat-practice', [App\Http\Controllers\AiController::class, 'chatPractice']);

// Licences Route
Route::get('/licences', [App\Http\Controllers\LicenceController::class, 'index']);

// Weeks Routes
Route::get('/weeks', [WeekController::class, 'index']);
Route::put('/weeks/{week}/toggle-complete', [WeekController::class, 'toggleComplete']);
Route::put('/weeks/{weekId}/checklist', [WeekController::class, 'updateChecklist']);
Route::put('/weeks/{weekId}/log-time', [WeekController::class, 'logTime']);
Route::put('/weeks/{weekId}/reset-progress', [WeekController::class, 'resetProgress']);
Route::put('/weeks/{weekId}/tasks/{taskIndex}/reset', [WeekController::class, 'resetTaskProgress']);

// Test Routes (if exists)
// Route::get('/weeks/{weekId}/tests', [TestController::class, 'getWeeklyTest']);
// Route::get('/tests/final', [TestController::class, 'getFinalTest']);
// Route::post('/tests/{testId}/submit', [TestController::class, 'submitTest']);
// Route::get('/progress', [WeekController::class, 'progress']);

// Fallback for CORS OPTIONS requests
Route::options('{any}', function () {
    return response('', 204)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', '*');
})->where('any', '.*');
