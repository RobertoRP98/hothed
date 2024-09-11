<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\WellOilController;
use App\Http\Controllers\ConditionController;
use App\Http\Controllers\ToolrentController;

Route::get('/', function () {
    return view('welcome');
});


Auth::routes(['register'=>false, 'reset'=>false]);
//
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Ruta comodín para capturar todas las rutas no definidas
Route::fallback(function () {
    return redirect('/');
});


//rutas para los clientes 
Route::resource('clientes', ClientController::class)->middleware('auth');
Route::resource('condiciones', ConditionController::class)->middleware('auth');
Route::resource('status', StatusController::class)->middleware('auth');
Route::resource('pozos', WellOilController::class)->middleware('auth');
Route::resource('herramientasrenta', ToolrentController::class)->middleware('auth');




