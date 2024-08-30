<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/entradasysalidas', function () {
    return view('/inout/inout');
});




Auth::routes(['register' => false]);
//
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Ruta comodín para capturar todas las rutas no definidas
Route::fallback(function () {
    return redirect('/');
});