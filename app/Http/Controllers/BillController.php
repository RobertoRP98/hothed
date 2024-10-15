<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Http\Requests\StoreBillRequest;
use App\Http\Requests\UpdateBillRequest;
use App\Models\CompanyReceivable;
use App\Models\Currency;
use Carbon\Carbon;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Obtener el valor del dolar desde el modelo
        $dollarRate = Currency::where('currency', 'USD')->latest()->value('rate');
        // Obtener los totales de empresas privadas
    $totalPrivadasPendienteFacturar = Bill::whereHas('companyreceivable', function ($query) {
        $query->where('type', 'Privada');
    })->where('status', 'pendiente_facturar')->sum('total_payment');

    $totalPrivadasPendienteCobrar = Bill::whereHas('companyreceivable', function ($query) {
        $query->where('type', 'Privada');
    })->where('status', 'pendiente_cobrar')->sum('total_payment');




    // Obtener los totales de empresas públicas
    //inicia calculos de pesos pendientes de facturar
    $totalPublicasPendienteFacturar= Bill::whereHas('companyreceivable', function($query){
        $query->where('type','Pemex');
    }) 
    ->where('status','pendiente_facturar')
    ->get()
    ->map(function($bill)use($dollarRate){
        //Si la empresa maneja MXN, convertir a USD
        if($bill->companyreceivable->currency == 'MXN'){
            return $bill->total_payment / $dollarRate;
        }else{
            return $bill->total_payment;
        }
    })->sum();

    $totalPublicasPendienteFacturar=number_format($totalPublicasPendienteFacturar);
    //termina calculos de pesos pendientes de facturar


    //empieza calculos de pesos pendientes de cobrar
    $totalPublicasPendienteCobrar = Bill::whereHas('companyreceivable', function ($query) {
        $query->where('type', 'Pemex');
    })
    ->where('status', 'pendiente_cobrar')
    ->get()
    ->map(function($bill)use($dollarRate){
        //Si la empresa maneja MXN, convertir a USD
        if($bill->companyreceivable->currency == 'MXN'){
            return $bill->total_payment / $dollarRate;
        }else{
            return $bill->total_payment;
        }
    })->sum();

    $totalPublicasPendienteCobrar=number_format($totalPublicasPendienteCobrar,2);
    //termina calculos de pesos pendiente de cobrar

    // Facturas vencidas o por vencer
    $facturas = Bill::all()->filter(function ($bill) {
        //comprar fechas de vencimiento con la fecha actual
        $expirationDate = Carbon::parse($bill->expiration_date);
        $today = Carbon::now();

        //diferencia en dias entre la fecha actual y la fecha de vencimiento
        $diasExpirados=$expirationDate->diffInDays($today, false);// negativo si aún no ha expirado

        //solo facturas con dias expirados >= 0 (vencidas o por vencer)
        return $diasExpirados >= 0;
    })->map(function($bill){
        $expirationDate= Carbon::parse($bill->expiration_date);
        $today= Carbon::now();
        $bill->diasExpirados = $expirationDate->diffInDays($today,false);
        return $bill;

    });



    return view('bill.index', compact(
        'totalPrivadasPendienteFacturar', 
        'totalPrivadasPendienteCobrar', 
        'totalPublicasPendienteFacturar',
        'totalPublicasPendienteCobrar',
        'facturas'
    ));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function createFactura($companyreceivable_id)
    {
        //esto nos ayuda pasar el id a la vista
        $company=CompanyReceivable::findOrFail($companyreceivable_id);
        
        //pasamos los demas datos de esa empresa
        $bill=null;

        
        return view('bill.create',
         ['company'=> $company, 
         'company_name'=>$company->name, 
         'company_type'=>$company->type,
         'company_creditdays'=>$company->creditdays], compact('bill'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBillRequest $request, $companyreceivable_id)
    {
        $field=['order_number'=>'required',];
        $message= ['required'=> 'El :attribute es requerido'];

        $this->validate($request, $field, $message);
        $datosbill= $request->except('_token','diasexpirados');
        // Obtén la fecha de entrada y los días de crédito
        $entryDate = Carbon::parse($request->input('entry_date')); // Fecha de entrada
        $company = CompanyReceivable::findOrFail($companyreceivable_id);
        $creditDays = $company->creditdays; // Días de crédito de la empresa

        // Calcula la fecha de expiración
         $expirationDate = $entryDate->copy()->addDays($creditDays);
         // Agrega la fecha de expiración y el ID de la empresa
         $datosbill['expiration_date'] = $expirationDate;
         $datosbill['companyreceivable_id'] = $companyreceivable_id;

        Bill::insert($datosbill);

        // Redirigir al perfil de la empresa después de guardar
        return redirect()->route('empresas.show', $companyreceivable_id)->with('message', 'Factura creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bill $bill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($companyreceivable_id, $id)
    {
                //esto nos ayuda pasar el id a la vista
                $company=CompanyReceivable::findOrFail($companyreceivable_id);

                //el id de la factura
                $bill=Bill::FindOrFail($id);
                
                return view('bill.edit',
                 ['company'=> $company, 
                 'company_name'=>$company->name, 
                 'company_type'=>$company->type,
                 'company_creditdays'=>$company->creditdays], compact('bill', 'company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBillRequest $request,$companyreceivable_id, $id)
    {
        $datosbill=request()->except(['_token','diasexpirados',('_method')]);
        // Obtén la fecha de entrada y los días de crédito
        $entryDate = Carbon::parse($request->input('entry_date')); // Fecha de entrada
         $company = CompanyReceivable::findOrFail($companyreceivable_id);
         $creditDays = $company->creditdays; // Días de crédito de la empresa

        // Calcula la fecha de expiración
        $expirationDate = $entryDate->copy()->addDays($creditDays);

        // Actualiza la fecha de expiración en los datos de la factura
        $datosbill['expiration_date'] = $expirationDate;

        // Actualiza la factura en la base de datos
        Bill::where('id', $id)->update($datosbill);

        // Redirige al perfil de la empresa
    return redirect()->route('empresas.show', $companyreceivable_id)->with('message', 'Factura actualizada exitosamente');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bill $bill)
    {
        //
    }
}
