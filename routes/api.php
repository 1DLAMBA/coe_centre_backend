<?php

use App\Http\Controllers\ApplicationController;
use Illuminate\Http\Request;
use App\Http\Controllers\BioDataController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseDataController;
use App\Http\Controllers\EducationalDetailsController;
use App\Http\Controllers\PersonalDetailController;
use App\Http\Controllers\StudentDetailController;
use Illuminate\Support\Facades\Route;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/courses', CourseController::class);
// Route::post('/courses-create', [CourseController::class, 'store']);
Route::post('/course-data/upload', [CourseDataController::class, 'upload']);
Route::get('/course-data', [CourseDataController::class, 'index']);
Route::get('/applications', [ApplicationController::class, 'index']);
Route::post('/applications', [ApplicationController::class, 'store']);
Route::post('/school-fees', [ApplicationController::class, 'school_fees']);
Route::post('/student_check', [PersonalDetailController::class, 'find']);
Route::apiResource('personal-details', PersonalDetailController::class);
Route::apiResource('student-details', StudentDetailController::class);
Route::apiResource('educational-details', EducationalDetailsController::class);
Route::get('/applications/{id}', [ApplicationController::class, 'show']);
Route::put('/applications/{id}', [ApplicationController::class, 'update']);
// Route::post('/student_check', [ApplicationController::class, 'studentCheck']);

Route::apiResource('bio-data', BioDataController::class);
// Route::get('/bio-data/{id}', [BioDataController::class, 'show']);
