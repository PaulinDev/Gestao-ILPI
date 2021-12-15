<?php

use App\Mail\newUserNotification;
use App\Models\Patient;
use App\Models\User;
use App\Models\Vaccine;
use App\Models\VaccineRecord;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

/* GESTÃO DOS FUNCIONÁRIOS */

Route::middleware('auth')->prefix('employees')->group(function () {
    Route::get('/edit/{id}', function ($id) {
        return view('app.employees.edit', ['pageName' => 'Cadastro de Funcionário', 'parentPage' => 'Funcionários', 'breadCrumb' => true, 'idCurrentEmployee' => $id]);
    })->name('user.edit.page');

    Route::get('/new', function () {
        return view('app.employees.new', ['pageName' => 'Cadastro de Funcionário', 'parentPage' => 'Funcionários', 'breadCrumb' => true]);
    })->name('user.create.page');

    Route::get('/list', function () {
        return view('app.employees.list', ['pageName' => 'Lista de Funcionários', 'parentPage' => 'Funcionários', 'breadCrumb' => true]);
    })->name('user.list.page');
});

/* TELA DOS RESPONSÁVEIS */

Route::middleware('auth')->prefix('relatives')->group(function () {
    Route::get('list', function () {
        return view('app.relatives.index', );
    })->name('relative.list.page');

    Route::get('view/{id}', function ($id) {
        return view('app.relatives.view', ['idCurrentPatient' => $id]);
    })->name('relative.view.page');
});

/* GESTÃO DAS ATIVIDADES */

Route::middleware('auth')->prefix('activity')->group(function () {

    Route::get('/group', function () {
        return view('app.activity.group');
    })->name('activity.group.page');

    Route::get('/view/{id}', function ($id) {
        return view('app.activity.view', ['idCurrentActivity' => $id]);
    })->name('activity.view.page');

});

/* GESTÃO DAS PATOLOGIAS */

Route::middleware('auth')->prefix('pathology')->group(function () {
    Route::get('/list', function () {
        return view('app.pathology.index');
    })->name('pathology.index.page');
});

/* GESTÃO DOS UTENTES */

Route::middleware('auth')->prefix('patients')->group(function () {
    Route::get('/edit/{id}', function ($id) {
        return view('app.patients.edit', ['pageName' => 'Cadastro de Funcionário', 'parentPage' => 'Funcionários', 'breadCrumb' => true, 'idCurrentEmployee' => $id]);
    })->name('patient.edit.page');

    Route::get('/view/{id}', function ($id) {
        return view('app.patients.view', ['pageName' => 'Cadastro de Funcionário', 'parentPage' => 'Funcionários', 'breadCrumb' => true, 'idCurrentPatient' => $id]);
    })->name('patient.view.page');

    Route::get('/list', function () {
        return view('app.patients.list', ['pageName' => 'Lista de Funcionários', 'parentPage' => 'Funcionários', 'breadCrumb' => true]);
    })->name('patient.list.page');
});


/* GESTÃO DAS VACINAS */

Route::middleware('auth')->prefix('vaccines')->group(function () {

    Route::get('', function (){
        return redirect(\route('vaccine.list.page'));
    });

    Route::get('/edit/{id}', function ($id) {
        return view('app.patients.edit', ['pageName' => 'Cadastro de Funcionário', 'parentPage' => 'Funcionários', 'breadCrumb' => true, 'idCurrentEmployee' => $id]);
    })->name('vaccine.edit.page');

    Route::get('/group', function () {
        return view('app.vaccine.index', ['countVaccines' => Patient::withCount('getVaccines')->with('getVaccines')->get()]);
    })->name('vaccine.list.page');

    Route::get('/view/{id}', function ($id) {
        $pageName = Vaccine::find($id);
        return view('app.vaccine.view', ['pageName' => $pageName->name, 'parentPage' => 'Vacinas', 'breadCrumb' => true, 'idVaccine' => $id]);
    })->name('vaccine.view');

    Route::get('/details/{id}', function ($id) {
        $pageName = Vaccine::find($id);
        return view('app.vaccine.details', ['pageName' => $pageName->name, 'parentPage' => 'Vacinas', 'breadCrumb' => true, 'idVaccine' => $id]);
    })->name('vaccine.details');
});


/* GESTÃO DOS AGENDAMENTOS */

Route::middleware('auth')->prefix('appointments')->group(function () {

    Route::get('', function (){
        return redirect(\route('appointments.index.page'));
    });

    Route::get('/list', function () {
        return view('app.appointments.index');
    })->name('appointments.index.page');
});

/* PÁGINA INICIAL ESCOLHA PARA ADM OU UTENTES */

Route::middleware('auth')->prefix('index')->group(function () {

    Route::get('', function (){
        return view('app.alternative.alternative');
    });
});

Route::get('testes', function () {
//    $vaccines = VaccineRecord::with('getVaccine')->with('getPatient')->get();
//
//    foreach ($vaccines as $x){
//        print_r($x->id);
//    }

    return Vaccine::withCount('getRecords')->get();

})->name('testes');
