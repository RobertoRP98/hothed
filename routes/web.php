<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\WellOilController;
use App\Http\Controllers\SubgroupController;
use App\Http\Controllers\ToolrentController;
use App\Http\Controllers\ConditionController;
use App\Http\Controllers\ToolHistoryController;
use App\Http\Controllers\TypemaintController;
use App\Http\Controllers\ToolstatusController;
use App\Http\Controllers\ToolwarehouseController;

Route::get('/', function () {
    return view('welcome');
});


Auth::routes(['reset'=>false]);
//
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Ruta comodín para capturar todas las rutas no definidas
//Route::fallback(function () {    return redirect('/');});



Route::resource('clientes', ClientController::class)->middleware('auth');
Route::resource('condiciones', ConditionController::class)->middleware('auth');
Route::resource('status', StatusController::class)->middleware('auth');
Route::resource('pozos', WellOilController::class)->middleware('auth');
Route::resource('herramientasrenta', ToolrentController::class)->middleware('auth');
Route::resource('tiposmantenimiento', TypemaintController::class)->middleware('auth');
Route::resource('bases', BaseController::class)->middleware('auth');
Route::resource('familias', FamilyController::class)->middleware('auth');
Route::resource('subgrupos', SubgroupController::class)->middleware('auth');
Route::resource('toolstatus', ToolstatusController::class)->middleware('auth');
//
Route::resource('almacenherramientas',ToolwarehouseController::class)->middleware('auth');
Route::get('/list', [ToolwarehouseController::class, 'list'])->middleware('auth');
Route::post('/search', [ToolwarehouseController::class, 'search'])->middleware('auth');
Route::resource('historialalmacen',ToolHistoryController::class)->middleware('auth');

//











