<?php

use App\Models\DocumentsTypes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\AreaSgiController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserSgiController;

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\SubgroupController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ToolstatusController;
use App\Http\Controllers\RequisitionController;
use App\Http\Controllers\WorkstationController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\ToolwarehouseController;
use App\Http\Controllers\DocumentsTypesController;
use App\Http\Controllers\AuthPurchaseOrderController;
use App\Http\Controllers\CompanyReceivableController;
use App\Http\Controllers\DocumentsCategoriesController;
use App\Http\Controllers\AuthorizationRequisitionController;

Route::get('/', function () {
    return view('welcome');
});


Auth::routes(['reset' => false, 'register' => false]);


// Grupo de rutas protegido con auth y roles específicos
Route::group(['middleware' => ['auth', 'role:Developer|AdministracionKarla']], function () {
    // Ruta para registrar usuarios, accesible solo para Developer y AdministracionKarla
    Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
});


//
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Errores 
Route::get('/error-403', function () {
    return view('errors.403');
})->name('error403');

//Errores 
Route::get('/error-405', function () {
    return view('errors.405');
})->name('error405');

//Errores 
Route::get('/new-index', function () {
    return view('errors.newindex');
})->name('newindex');

// Ruta comodín para capturar todas las rutas no definidas
//Route::fallback(function () {    return redirect('/');});


// EMPIEZA ALMACEN
Route::group(['middleware' => ['auth', 'role:Developer']], function () {
    Route::resource('almacen-herramientas', ToolwarehouseController::class)->middleware('auth');
    Route::get('historial-almacen', [ToolwarehouseController::class, 'history'])->middleware('auth')->name('toolwarehouse.history');
    Route::resource('familias', FamilyController::class)->middleware('auth');
    Route::resource('subgrupos', SubgroupController::class)->middleware('auth');
    Route::resource('toolstatus', ToolstatusController::class)->middleware('auth');
    Route::resource('bases', BaseController::class)->middleware('auth');

    Route::get('/export-herramientas', [ToolwarehouseController::class, 'exportReporteHerramientas'])->name('export.herramientas');
});
// TERMINA ALMACEN


//MODULOS DE COBRO
//LIMITADOR A SOLOS CON ROLE COBRANZA PUEDAN ACCEDER

Route::group(['middleware' => ['auth', 'role:Cobranza|Developer|AdministracionKarla|VerCobranza']], function () {

    Route::resource('empresas', CompanyReceivableController::class)->middleware('auth');
    Route::get('catalogo/privadas', [CompanyReceivableController::class, 'indexprivate'])->name('empresas.privadas')->middleware('auth');
    Route::get('catalogo/pemex', [CompanyReceivableController::class, 'indexPublicas'])->name('empresas.publicas')->middleware('auth');
    Route::get('/catalogo/{id}', [CompanyReceivableController::class, 'showEmpresa'])->name('empresas.show')->middleware('auth');
    // Ruta para el historial de facturación de una empresa específica
    Route::get('historial/{company}', [CompanyReceivableController::class, 'history'])->name('empresa.historial')->middleware('auth');

    // Ruta para el historial de facturas pagadas de una empresa específica
    Route::get('facturas-pagadas/{company}', [CompanyReceivableController::class, 'paid'])->name('empresa.facturas-pagadas')->middleware('auth');

    Route::get('/facturas', [BillController::class, 'index'])->name('facturas.index')->middleware('auth');

    //Index de todas las facturas privadas que estan vencidas
    Route::get('/privadas-vencidas', [BillController::class, 'facturasvencidasprivadas'])->name('privadas-vencidas')->middleware('auth');
    //Index de todas las facturas privadas que NO estan vencidas
    Route::get('/privadas-no-vencidas', [BillController::class, 'facturasnovencidasprivadas'])->name('privadas-no-vencidas')->middleware('auth');


    //Index de todas las facturas publicas que estan vencidas
    Route::get('/pemex-vencidas', [BillController::class, 'facturasvencidaspublicas'])->name('publicas-vencidas')->middleware('auth');
    //Index de todas las facturas publicas que NO estan vencidas
    Route::get('/pemex-no-vencidas', [BillController::class, 'facturasnovencidaspublicas'])->name('publicas-no-vencidas')->middleware('auth');


    //Exportar Excel con todas las empresas
    Route::get('/export-empresas', [BillController::class, 'exportEmpresas'])->name('export.empresas');

    Route::get('/export-privadas-vencidas', [BillController::class, 'exportPrivadasVencidas'])->name('export.privadas-vencidas');

    Route::get('/export-privadas-no-vencidas', [BillController::class, 'exportPrivadasNoVencidas'])->name('export.privadas-no-vencidas');

    Route::get('/export-publicas-vencidas', [BillController::class, 'exportPublicasVencidas'])->name('export.publicas-vencidas');

    Route::get('/export-publicas-no-vencidas', [BillController::class, 'exportPublicasNoVencidas'])->name('export.publicas-no-vencidas');

    Route::get('/export-pendientes-cobrar-global', [BillController::class, 'exportpendienteCobrarGlobal'])->name('export.pendientes-cobrar-global');



    //EXCELES POR EMPRESA INDIVIDUAL
    Route::get('/catalogo/{id}/export', [CompanyReceivableController::class, 'exportEmpresaExcel'])->name('empresas.export')->middleware('auth');

    Route::get('/catalogo/{id}/exportpf', [CompanyReceivableController::class, 'exportEmpresaPendienteFacturar'])->name('empresas.export.pf')->middleware('auth');

    Route::get('/catalogo/{id}/exportpc', [CompanyReceivableController::class, 'exportEmpresaPendienteCobrar'])->name('empresas.export.pc')->middleware('auth');

    Route::get('/catalogo/{id}/exportpe', [CompanyReceivableController::class, 'exportEmpresaPendienteEntrada'])->name('empresas.export.pe')->middleware('auth');

    //
    Route::get('/export-resumen-semanal', [BillController::class, 'exportReporteSemanal'])->name('export.resumen-semanal');
    //
    Route::get('/export-resumen-semanal-actual', [BillController::class, 'exportReporteSemanaActual'])->name('export.resumen-semana-actual');

    Route::get('/send-email', [BillController::class, 'sendHelloWorldEmail']);
});



Route::group(['middleware' => ['auth', 'role:Cobranza']], function () {

    Route::resource('divisas', CurrencyController::class)->middleware('auth');

    Route::get('/prefactura/create/{companyreceivable_id}', [BillController::class, 'createFactura'])->name('prefactura.create')->middleware('auth');
    // Para crear una factura y relacionarla con la empresa
    Route::post('/facturas/{companyreceivable_id}', [BillController::class, 'store'])->name('facturas.store')->middleware('auth');
    // Para actualizar una factura relacionada con la empresa
    Route::patch('facturas/update/{companyreceivable_id}/{factura}', [BillController::class, 'update'])->name('facturas.update')->middleware('auth');
    // Para editar una factura
    Route::get('/facturas/{companyreceivable_id}/edit/{factura}', [BillController::class, 'edit'])->name('facturas.edit')->middleware('auth');
});
//TERMINA MODULOS DE COBRO


//EMPIEZAN MODULOS DE COMPRAS  
//RUTAS PARA TODO EL PERSONAL CREAR Y GUARDAR SUS REQUISICIONES Y VER SUS PROPIAS REQUIS
// Route::group(['middleware' => ['auth', 'role:Developer|RespCompras|Auxalmacen|Auxopeventas|Coordrh|
// Auxcontratos|Coordconta|Coordalm|Subgerope|Gerope|Respsgi|Diradmin|Dirope|Coordcontratos|Mcfly']], function () {
//     Route::get('/requisiciones/create', [RequisitionController::class, 'create'])->name('requisiciones.create');
//     Route::post('/requisiciones', [RequisitionController::class, 'store'])->name('requisiciones.store');
//     Route::get('/requisiciones/{requisicione}', [RequisitionController::class, 'show'])->name('requisiciones.show');
//     //RUTA DE PDF PARA LAS REQUISICIONES
//     Route::get('/requisiciones/{requisicione}/pdf', [RequisitionController::class, 'pdf'])->name('requisiciones.pdf');

//     Route::get('/mis-requisiciones', [AuthorizationRequisitionController::class, 'indexclient'])->name('requisicionesclient.index');
//     Route::get('/productos-cliente', [AuthorizationRequisitionController::class, 'productclient'])->name('productclient.index');
// });

Route::group(['middleware' => ['auth']], function () {
    Route::get('/requisiciones/create', [RequisitionController::class, 'create'])->name('requisiciones.create');
    Route::post('/requisiciones', [RequisitionController::class, 'store'])->name('requisiciones.store');
    Route::get('/requisiciones/{requisicione}', [RequisitionController::class, 'show'])->name('requisiciones.show');
    //RUTA DE PDF PARA LAS REQUISICIONES
    Route::get('/requisiciones/{requisicione}/pdf', [RequisitionController::class, 'pdf'])->name('requisiciones.pdf');

    Route::get('/mis-requisiciones', [AuthorizationRequisitionController::class, 'indexclient'])->name('requisicionesclient.index');
    Route::get('/mis-ordenes', [AuthPurchaseOrderController::class, 'misordenes'])->name('ordenesclient.index');
    Route::get('/orden-user/{purchaseOrder}/requisiciones/{requisicione}/pdf', [PurchaseOrderController::class, 'pdfclient'])->name('ordencompra.pdfclient');


    Route::get('/productos-cliente', [AuthorizationRequisitionController::class, 'productclient'])->name('productclient.index');

    Route::get('/export-productos-compras', [ProductController::class, 'exportProductosCompra'])->name('export-productos-compras');

    Route::get('/export-mis-ordenes', [PurchaseOrderController::class, 'exportReporteMisOrdenes'])->name('export-mis-ordenes');

});
//RUTAS QUE SOLO SON ACCESIBLES AL ENCARGADO DE COMPRAS

Route::group(['middleware' => ['auth', 'role:Developer|RespCompras']], function () {
    Route::resource('/impuestos', TaxController::class);
    Route::resource('/proveedores', SupplierController::class);
    Route::resource('/productos', ProductController::class);
    Route::get('/requisiciones', [RequisitionController::class, 'index'])->name('requisiciones.index');
    Route::get('/compras-por-fechas', [PurchaseOrderController::class, 'verReporteRangos'])->name('compras.rangos.index');

    //INICIA ORDENES DE COMPRAS
    Route::get('/ordenes-compra', [PurchaseOrderController::class, 'index'])->name('ordencompra.index');

    Route::get('/ordenes-compra/pendientes', [PurchaseOrderController::class, 'indexpend'])->name('ordencompra.indexpend');

    Route::get('/ordenes-compra/rechazadas', [PurchaseOrderController::class, 'indexcanc'])->name('ordencompra.indexcanc');

    Route::get('/ordenes-compra/finalizadas', [PurchaseOrderController::class, 'indexfinalizadas'])->name('ordencompra.indexfinalizadas');

    Route::get('/ordenes-compra/pagadas', [PurchaseOrderController::class, 'indexpagadas'])->name('ordencompra.indexpagadas');

    Route::get('/ordenes-compra/facturadas', [PurchaseOrderController::class, 'indexfacturadas'])->name('ordencompra.indexfacturadas');

    Route::get('/ordenes-compra/no-facturadas', [PurchaseOrderController::class, 'indexnofacturadas'])->name('ordencompra.indexnofacturadas');

    Route::get('/requisiciones/{requisicione}/ordenes-compra/create', [PurchaseOrderController::class, 'create'])->name('ordencompra.create');

    Route::post('/requisiciones/{requisicione}/ordenes-compra', [PurchaseOrderController::class, 'store'])->name('ordencompra.store');

    Route::get('/export-compras-locales', [PurchaseOrderController::class, 'exportReporteLocales'])->name('export.compras-locales');

    Route::get('/export-compras-extranjeras', [PurchaseOrderController::class, 'exportReporteExtranjeras'])->name('export.compras-extranjeras');

    Route::get('/export-proveedores', [PurchaseOrderController::class, 'exportProveedores'])->name('export.proveedores');

 //   Route::get('/export-compras-global', [PurchaseOrderController::class, 'exportReporteGlobalCompras'])->name('export.compras-global');

    Route::get('/export-compras-rango', [PurchaseOrderController::class, 'exportReporteRangos'])->name('export.compras-rango');

//    Route::get('/export-proveedores-locales', [PurchaseOrderController::class, 'exportProveedoresPagadas'])->name('export.proveedores-pagadas');


});

//RUTAS DE EXCELES PARA CONTABILIDAD Y RESP DE COMPRAS 
Route::group(['middleware' => ['auth', 'role:Developer|RespCompras|Auxconta|Coordconta']], function () {

    Route::get('/export-compras-global', [PurchaseOrderController::class, 'exportReporteGlobalCompras'])->name('export.compras-global');

    Route::get('/export-proveedores-locales', [PurchaseOrderController::class, 'exportProveedoresPagadas'])->name('export.proveedores-pagadas');
});

//RUTAS QUE SOLO SON ACCESIBLES AL ENCARGADO DE COMPRAS, DIRECTORA GENERAL Y GER DE OPERACIONES PARA AUTORIZAR Y VER OCS
Route::group(['middleware' => ['auth', 'role:Developer|RespCompras|Diradmin|Gerope']], function () {

    Route::get('/ordenes-compra/{purchaseOrder}/requisiciones/{requisicione}/edit', [PurchaseOrderController::class, 'edit'])->name('ordencompra.edit');

    Route::patch('/ordenes-compra/{purchaseOrder}/requisiciones/{requisicione}/', [PurchaseOrderController::class, 'update'])->name('ordencompra.update');

    Route::get('/ordenes-compra/{purchaseOrder}/requisiciones/{requisicione}/show', [PurchaseOrderController::class, 'show'])->name('ordencompra.show');
});

//RUTAS QUE SOLO SON ACCESIBLES AL ENCARGADO DE COMPRAS Y A LA DIRECTORA PARA LA PRE AUTORIZACION DE ADMINISTRACION
Route::group(['middleware' => ['auth', 'role:Developer|RespCompras|Diradmin']], function () {

    //INICIA INDEX PRE AUTORIZACION DE ADMINISTRACION
    Route::get('/ordenes-compra/pre-autorizacio/adm/pendientes', [AuthPurchaseOrderController::class, 'indexpendienteadm'])->name('preadmpendientes.index');
    Route::get('/ordenes-compra/pre-autorizacio/adm/autorizadas', [AuthPurchaseOrderController::class, 'indextautorizadoadm'])->name('preadmautorizadas.index');
    Route::get('/ordenes-compra/pre-autorizacio/adm/canceladas', [AuthPurchaseOrderController::class, 'indexrechazadoadm'])->name('preadmcanceladas.index');
    Route::get('/ordenes-compra/{purchaseOrder}/requisiciones/{requisicione}/preaut', [AuthPurchaseOrderController::class, 'editpreaut'])->name('preaut.edit');
});

//RUTAS QUE SOLO SON ACCESIBLES AL ENCARGADO DE COMPRAS Y A LA DIRECTORA PARA LA PRE AUTORIZACION DE ADMINISTRACION
Route::group(['middleware' => ['auth', 'role:Developer|RespCompras|Diradmin|Gerope']], function () {

    //INICIA INDEX PRE AUTORIZACION DE ADMINISTRACION
    Route::get('/ordenes-compra/pre-autorizacio/ope/pendientes', [AuthPurchaseOrderController::class, 'indexpendienteope'])->name('preopependientes.index');
    Route::get('/ordenes-compra/pre-autorizacio/ope/autorizadas', [AuthPurchaseOrderController::class, 'indextautorizadoope'])->name('preopeautorizadas.index');
    Route::get('/ordenes-compra/pre-autorizacio/ope/canceladas', [AuthPurchaseOrderController::class, 'indexrechazadoope'])->name('preopecanceladas.index');
    Route::get('/ordenes-compra/{purchaseOrder}/requisiciones/{requisicione}/preaut', [AuthPurchaseOrderController::class, 'editpreaut'])->name('preaut.edit');
});

//RUTAS QUE SOLO SON ACCESIBLES AL ENCARGADO DE COMPRAS Y A LA DIRECTORA PARA LA AUTORIZACION DE ADMINISTRACION
Route::group(['middleware' => ['auth', 'role:Developer|RespCompras|Diradmin|']], function () {

    //INICIA INDEX AUTORIZACION DE ADMINISTRACION
    Route::get('/ordenes-compra/autorizacion/pendientes', [AuthPurchaseOrderController::class, 'indexpendientedir'])->name('dirpendientes.index');
    Route::get('/ordenes-compra/autorizacion/pendientes/responsable', [AuthPurchaseOrderController::class, 'indexpendienteresp'])->name('resppendientes.index');
    Route::get('/ordenes-compra/autorizacion/autorizadas', [AuthPurchaseOrderController::class, 'indextautorizadodir'])->name('dirautorizadas.index');
    Route::get('/ordenes-compra/autorizacion/canceladas', [AuthPurchaseOrderController::class, 'indexrechazadodir'])->name('dircanceladas.index');
});

//RUTAS QUE SOLO SON ACCESIBLES AL ENCARGADO DE COMPRAS Y A LA DIRECTORA PARA LA AUTORIZACION DE ADMINISTRACION
Route::group(['middleware' => ['auth', 'role:Developer|RespCompras|Diradmin']], function () {
    Route::get('/ordenes-compra/{purchaseOrder}/requisiciones/{requisicione}/aut', [AuthPurchaseOrderController::class, 'editdirectora'])->name('autdir.edit');
});


//RUTAS QUE SOLO SON ACCESIBLES AL ENCARGADO DE COMPRAS,DIRECTORA, GEROPE PARA VER LOS PDF DE LAS OC
Route::group(['middleware' => ['auth', 'role:Developer|RespCompras|Diradmin|Gerope|Contamex|Auxconta|Coordconta']], function () {
    Route::get('/ordenes-compra/{purchaseOrder}/requisiciones/{requisicione}/pdf', [PurchaseOrderController::class, 'pdf'])->name('ordencompra.pdf');
});

//RUTA PARA QUE NORMA PUEDA VER LAS OC QUE A APROBADO LA DIRECTORA
Route::group(['middleware' => ['auth', 'role:Developer|Contamex']], function () {
    Route::get('/ordenes-compra-autorizadas', [PurchaseOrderController::class, 'indexautgeneral'])->name('ordencompra.autorizadas');
});

//RUTAS PARA EL REPOSITORIO DE COMPRAS
Route::group(['middleware' => ['auth', 'role:Developer|Diradmin|Gerope|Contamex|RespCompras|Auxconta|Coordconta']], function () {
    Route::get('/repositorio-ordenes-compra', [PurchaseOrderController::class, 'indexrepositorio'])->name('ordencompra.repositorio');
});


//RUTAS Index de autorizaciones
Route::group(
    ['middleware' => ['auth', 'role:Developer|RespCompras|Coordconta|Coordalm|Subgerope|Gerope|Respsgi|Diradmin|Dirope|Coordcontratos']],
    function () {
        Route::get('/requisiciones/{requisicione}/edit', [RequisitionController::class, 'edit'])->name('requisiciones.edit');
        Route::patch('/requisiciones/{requisicione}', [RequisitionController::class, 'update'])->name('requisiciones.update');


        //ACCESOS LOS INDEX DONDE LOS JEFES INMEDIATOS AUTORIZAN LAS REQUISICIONES
        //Rutas para ver las requisiciones por departamentos ADM U OP
        Route::get('requisiciones-almacen', [AuthorizationRequisitionController::class, 'indexalm'])->name('requisicionesalm');
        Route::get('requisiciones-almacen-autorizadas', [AuthorizationRequisitionController::class, 'autalm'])->name('requisicionesalmaut');
        Route::get('requisiciones-almacen-canceladas', [AuthorizationRequisitionController::class, 'canalm'])->name('requisicionesalmcan');
        Route::get('requisiciones-almacen-finalizadas', [AuthorizationRequisitionController::class, 'finalm'])->name('requisicionesalmfin');

        Route::get('requisiciones-administracion', [AuthorizationRequisitionController::class, 'indexadmin'])->name('requisicionesadmin');
        Route::get('requisiciones-admin-autorizadas', [AuthorizationRequisitionController::class, 'autadmin'])->name('requisicionesadminaut');
        Route::get('requisiciones-admin-canceladas', [AuthorizationRequisitionController::class, 'canadmin'])->name('requisicionesadmincan');
        Route::get('requisiciones-admin-finalizadas', [AuthorizationRequisitionController::class, 'finadmin'])->name('requisicionesadminfin');

        // NO ESTA NORMALIZADO
        Route::get('requisiciones-contabilidad', [AuthorizationRequisitionController::class, 'indexcoordconta'])->name('requisicionescoordconta.index');
        Route::get('requisiciones-contabilidad-autorizadas', [AuthorizationRequisitionController::class, 'autconta'])->name('requisicionescontaaut');
        Route::get('requisiciones-contabilidad-canceladas', [AuthorizationRequisitionController::class, 'canconta'])->name('requisicionescontacan');
        Route::get('requisiciones-contabilidad-finalizadas', [AuthorizationRequisitionController::class, 'finconta'])->name('requisicionescontafin');
        //

        Route::get('requisiciones-contratos', [AuthorizationRequisitionController::class, 'indexcontra'])->name('requisicionescontra');
        Route::get('requisiciones-contratos-autorizadas', [AuthorizationRequisitionController::class, 'autcontra'])->name('requisicionescontraaut');
        Route::get('requisiciones-contratos-canceladas', [AuthorizationRequisitionController::class, 'cancontra'])->name('requisicionescontracan');
        Route::get('requisiciones-contratos-finalizadas', [AuthorizationRequisitionController::class, 'fincontra'])->name('requisicionescontrafin');

        Route::get('requisiciones-dirope', [AuthorizationRequisitionController::class, 'indexdirope'])->name('requisicionesgerope');
        Route::get('requisiciones-dirope-autorizadas', [AuthorizationRequisitionController::class, 'autdirope'])->name('requisicionesgeropeaut');
        Route::get('requisiciones-dirope-canceladas', [AuthorizationRequisitionController::class, 'candirope'])->name('requisicionesgeropecan');
        Route::get('requisiciones-dirope-finalizadas', [AuthorizationRequisitionController::class, 'findirope'])->name('requisicionesgeropefin');

        Route::get('requisiciones-gerope', [AuthorizationRequisitionController::class, 'indexgerope'])->name('requisicionesgerope');
        Route::get('requisiciones-gerope-autorizadas', [AuthorizationRequisitionController::class, 'autgerope'])->name('requisicionesgeropeaut');
        Route::get('requisiciones-gerope-canceladas', [AuthorizationRequisitionController::class, 'cangerope'])->name('requisicionesgeropecan');
        Route::get('requisiciones-gerope-finalizadas', [AuthorizationRequisitionController::class, 'fingerope'])->name('requisicionesgeropefin');

        Route::get('requisiciones-sgi', [AuthorizationRequisitionController::class, 'indexsgi'])->name('requisicionessgi');
        Route::get('requisiciones-sgi-autorizadas', [AuthorizationRequisitionController::class, 'autsgi'])->name('requisicionessgiaut');
        Route::get('requisiciones-sgi-canceladas', [AuthorizationRequisitionController::class, 'cansgi'])->name('requisicionessgican');
        Route::get('requisiciones-sgi-finalizadas', [AuthorizationRequisitionController::class, 'finsgi'])->name('requisicionessgifin');

        Route::get('requisiciones-subope', [AuthorizationRequisitionController::class, 'indexsubope'])->name('requisicionessubope');
        Route::get('requisiciones-subope-autorizadas', [AuthorizationRequisitionController::class, 'autsubope'])->name('requisicionessubopeaut');
        Route::get('requisiciones-subope-canceladas', [AuthorizationRequisitionController::class, 'cansubope'])->name('requisicionessubopecan');
        Route::get('requisiciones-subope-finalizadas', [AuthorizationRequisitionController::class, 'finsubope'])->name('requisicionessubopefin');

        Route::get('requisiciones-resp-pendientes-aut', [AuthorizationRequisitionController::class, 'indexresppend'])->name('requisicionesresppend.index');
        Route::get('requisiciones-resp-canceladas', [AuthorizationRequisitionController::class, 'indexrespcan'])->name('requisicionesrespcan.index');
        Route::get('requisiciones-resp-finalizadas', [AuthorizationRequisitionController::class, 'indexrespfin'])->name('requisicionesrespfin.index');
    }
);
//TERMINAN MODULOS DE COMPRAS


//INICIA MODULO DE DOCUMENTOS

//RUTAS PARA EDITAR SOLO SON ACCESIBLES PARA GERENCIA Y RESPONSABLE DE COMPRAS
Route::group(
    ['middleware' => ['auth', 'role:Developer|Respsgi']],
    function () {
        Route::resource('puestos-trabajo', WorkstationController::class);
        Route::resource('areas-sgi', AreaSgiController::class);
        Route::resource('users-sgi', UserSgiController::class);
        Route::resource('categorias-documentos', DocumentsCategoriesController::class);
        Route::resource('tipos-documentos', DocumentsTypesController::class);


        Route::get('documentacion-sgi',[DocumentController::class,'index'])->name('documentacion-sgi.index');

        Route::get('documentacion-sgi/create',[DocumentController::class,'create'])->name('documentacion-sgi.create');
        Route::post('documentacion-sgi',[DocumentController::class,'store'])->name('documentacion-sgi.store');

        Route::get('documentacion-sgi/{document}/edit',[DocumentController::class,'edit'])->name('documentacion-sgi.edit');
        Route::patch('documentacion-sgi/{document}',[DocumentController::class,'update'])->name('documentacion-sgi.update');

        Route::get('/documentos/download/{type}/{id}', [DocumentController::class, 'download'])->name('documentos.download');

        Route::get('documentos/ver/{id}',[DocumentController::class,'verpdf'])->name('verpdf');

        



        // Route::get('/users-sgi/{id}/jefe',[UserSgiController::class,'jefeinmediato']);


        Route::get('/phpinfo', function () {
    phpinfo();
});
    }
);
//FINALIZA MODULO DE DOCUMENTOS