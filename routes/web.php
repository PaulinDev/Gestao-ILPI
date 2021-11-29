<?php

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
