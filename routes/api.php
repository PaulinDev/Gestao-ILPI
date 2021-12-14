<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CivilController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EventActivityController;
use App\Http\Controllers\GenderController;
use App\Http\Controllers\GroupActivityController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\InventoryTypeController;
use App\Http\Controllers\OccupationController;
use App\Http\Controllers\PathologyController;
use App\Http\Controllers\PathologyRecordController;
use App\Http\Controllers\PatientAddressController;
use App\Http\Controllers\PatientCardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PatientInventoryController;
use App\Http\Controllers\TherapyController;
use App\Http\Controllers\UserHealthController;
use App\Http\Controllers\UserController;
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

    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

    Route::apiResources([
        'patients' => PatientController::class,
        'pathology' => PathologyController::class,
        'pathology-record' => PathologyRecordController::class,
        'appointments' => AppointmentController::class,
        'activity-patient' => EventActivityController::class,
        'activity-group' => GroupActivityController::class,
        'activities' => ActivityController::class,
        'user-health' => UserHealthController::class,
        'patient-cards' => PatientCardController::class,
        'patient-address' => PatientAddressController::class,
        'patient-inventory' => PatientInventoryController::class,
        'inventory-type' => InventoryTypeController::class,
        'employees' => EmployeeController::class,
        'users' => UserController::class,
        'guardian' => GuardianController::class,
        'countries' => CountryController::class,
        'genders' => GenderController::class,
        'civils' => CivilController::class,
        'educations' => EducationController::class,
        'occupations' => OccupationController::class,
        'user-posts' => UserPostController::class,
        'therapy' => TherapyController::class,
        'user-permission' => UserPermissionController::class,
        'vaccines' => VaccineController::class,
        'vaccine-brand' => VaccineBrandController::class,
        'vaccine-record' => VaccineRecordController::class,
    ]);
    Route::get('vaccine-brand/vaccine/{id}', [VaccineBrandController::class, 'showBrandVaccine'])->name('api.vaccineBrand');
    Route::get('vaccine/patient', [VaccineController::class, 'showPatientVaccine'])->name('api.vaccinePatient');
    Route::get('vaccine/count/{id}', [VaccineRecordController::class, 'vaccineCount'])->name('api.vaccineCount');
    Route::get('inventory/patient/{id}', [PatientInventoryController::class, 'getInventoryPatient'])->name('api.inventoryByPatient');
});

Route::middleware('cors')->post('login', [AuthController::class, 'login']);
