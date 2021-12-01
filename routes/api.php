<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EventActivityController;
use App\Http\Controllers\GenderController;
use App\Http\Controllers\GroupActivityController;
use App\Http\Controllers\OccupationController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\UserPermissionController;
use App\Http\Controllers\UserPostController;
use App\Http\Controllers\VaccineBrandController;
use App\Http\Controllers\VaccineController;
use App\Http\Controllers\VaccineRecordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->middleware(['jwt.auth'])->group(function () {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

    Route::apiResources([
        'patients' => PatientController::class,
        'activity-patient' => EventActivityController::class,
        'activity-group' => GroupActivityController::class,
        'activities' => ActivityController::class,
        'employees' => EmployeeController::class,
        'genders' => GenderController::class,
        'user-posts' => UserPostController::class,
        'user-permission' => UserPermissionController::class,
        'vaccines' => VaccineController::class,
        'vaccine-brand' => VaccineBrandController::class,
        'vaccine-record' => VaccineRecordController::class,
        'occupations' => OccupationController::class
    ]);

});

Route::post('login', [AuthController::class, 'login']);
