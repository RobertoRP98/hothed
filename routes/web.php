<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompanyReceivableController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\WellOilController;
use App\Http\Controllers\SubgroupController;
use App\Http\Controllers\ToolrentController;
use App\Http\Controllers\ConditionController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\TypemaintController;
use App\Http\Controllers\ToolstatusController;
use App\Http\Controllers\ToolHistoryController;
use App\Http\Controllers\ToolwarehouseController;

Route::get('/', function () {
    return view('welcome');
});


Auth::routes(['reset'=>false,'register'=>false]);
//
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Errores 
Route::get('/error-403',function(){return view('errors.403');})->name('error403');

//Errores 
Route::get('/new-index',function(){return view('errors.newindex');})->name('newindex');

// Ruta comodín para capturar todas las rutas no definidas
//Route::fallback(function () {    return redirect('/');});



Route::resource('clientes', ClientController::class)->middleware('auth');
Route::resource('condiciones', ConditionController::class)->middleware('auth');
Route::resource('status', StatusController::class)->middleware('auth');
Route::resource('pozos', WellOilController::class)->middleware('auth');
Route::resource('herramientasrenta', ToolrentController::class)->middleware('auth');
Route::resource('tiposmantenimiento', TypemaintController::class)->middleware('auth');

// EMPIEZA ALMACEN
Route::group(['middleware'=> ['auth','checkrole:Almacen']], function(){
Route::resource('bases', BaseController::class)->middleware('auth');
Route::resource('familias', FamilyController::class)->middleware('auth');
Route::resource('subgrupos', SubgroupController::class)->middleware('auth');
Route::resource('toolstatus', ToolstatusController::class)->middleware('auth');
Route::resource('almacenherramientas',ToolwarehouseController::class)->middleware('auth');
Route::get('/list', [ToolwarehouseController::class, 'list'])->middleware('auth');
Route::post('/search', [ToolwarehouseController::class, 'search'])->middleware('auth');
Route::resource('historialalmacen',ToolHistoryController::class)->middleware('auth');
});
// TERMINA ALMACEN


//MODULOS DE COBRO
//LIMITADOR A SOLOS CON ROLE COBRANZA PUEDAN ACCEDER
Route::group(['middleware'=>['auth','checkrole:Cobranza']], function(){

Route::resource('divisas',CurrencyController::class)->middleware('auth');

Route::resource('empresas',CompanyReceivableController::class)->middleware('auth');
Route::get('catalogo/privadas', [CompanyReceivableController::class, 'indexprivate'])->name('empresas.privadas')->middleware('auth');
Route::get('catalogo/pemex', [CompanyReceivableController::class, 'indexPublicas'])->name('empresas.publicas')->middleware('auth');
Route::get('/catalogo/{id}', [CompanyReceivableController::class, 'showEmpresa'])->name('empresas.show')->middleware('auth');
// Ruta para el historial de facturación de una empresa específica
Route::get('historial/{company}', [CompanyReceivableController::class, 'history'])->name('empresa.historial')->middleware('auth');

// Ruta para el historial de facturas pagadas de una empresa específica
Route::get('facturas-pagadas/{company}', [CompanyReceivableController::class, 'paid'])->name('empresa.facturas-pagadas')->middleware('auth');





Route::get('/prefactura/create/{companyreceivable_id}', [BillController::class, 'createFactura'])->name('prefactura.create')->middleware('auth');
// Para crear una factura y relacionarla con la empresa
Route::post('/facturas/{companyreceivable_id}', [BillController::class, 'store'])->name('facturas.store')->middleware('auth');
// Para actualizar una factura relacionada con la empresa
Route::patch('facturas/update/{companyreceivable_id}/{factura}', [BillController::class, 'update'])->name('facturas.update')->middleware('auth');
// Para editar una factura
Route::get('/facturas/{companyreceivable_id}/edit/{factura}', [BillController::class, 'edit'])->name('facturas.edit')->middleware('auth');
//
Route::get('/facturas', [BillController::class,'index'])->name('facturas.index')->middleware('auth');

//Index de todas las facturas privadas que estan vencidas
Route::get('/privadas-vencidas',[BillController::class,'facturasvencidasprivadas'])->name('privadas-vencidas')->middleware('auth');
//Index de todas las facturas privadas que NO estan vencidas
Route::get('/privadas-no-vencidas',[BillController::class,'facturasnovencidasprivadas'])->name('privadas-no-vencidas')->middleware('auth');


//Index de todas las facturas publicas que estan vencidas
Route::get('/pemex-vencidas',[BillController::class,'facturasvencidaspublicas'])->name('publicas-vencidas')->middleware('auth');
//Index de todas las facturas publicas que NO estan vencidas
Route::get('/pemex-no-vencidas',[BillController::class,'facturasnovencidaspublicas'])->name('publicas-no-vencidas')->middleware('auth');


//Exportar Excel con todas las empresas
Route::get('/export-empresas', [BillController::class, 'exportEmpresas'])->name('export.empresas');


});

//TERMINA MODULOS DE COBRO





