<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bill;
use App\Models\Currency;
use App\Exports\EmpresasExport;
use App\Models\CompanyReceivable;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreBillRequest;
use App\Http\Requests\UpdateBillRequest;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener el valor del dólar desde el modelo
        $dollarRate = Currency::where('currency', 'USD')->latest()->value('rate');

        // **Totales empresas privadas**
        // Pendiente de facturar
        $totalPrivadasPendienteFacturar = Bill::whereHas('companyreceivable', function ($query) {
            $query->where('type', 'Privada');
        })->where('status', 'pendiente_facturar')
            ->sum('total_payment');

        // Monto total de las facturas vencidas pendientes de cobrar 
        $totalPrivadasVencidas = Bill::whereHas('companyreceivable', function ($query) {
            $query->where('type', 'Privada');
        })->where('status', 'pendiente_cobrar')
            ->get()
            ->filter(function ($bill) {
                $expirationDate = Carbon::parse($bill->expiration_date);
                $today = Carbon::now();
                return $expirationDate->diffInDays($today, false) >= 0; // SOLO VENCIDAS
            })
            ->sum('total_payment');

        // Monto total de las facturas no vencidas pendientes de cobrar 
        $totalPrivadasNoVencidas = Bill::whereHas('companyreceivable', function ($query) {
            $query->where('type', 'Privada');
        })
            ->where('status', 'pendiente_cobrar')
            ->get()
            ->filter(function ($bill) {
                $expirationDate = Carbon::parse($bill->expiration_date);
                $today = Carbon::now();
                return $expirationDate->diffInDays($today, false) < 0; // SOLO NO VENCIDAS
            })
            ->sum('total_payment');

        // **Totales empresas públicas (Pemex)**
        // Pendiente de facturar
        $totalPublicasPendienteFacturar = Bill::whereHas('companyreceivable', function ($query) {
            $query->where('type', 'Pemex');
        })
            ->where('status', 'pendiente_facturar')
            ->get()
            ->map(function ($bill) use ($dollarRate) {
                return $bill->companyreceivable->currency == 'MXN' ? $bill->total_payment / $dollarRate : $bill->total_payment;
            })->sum();

        // Monto total de las facturas vencidas pendientes de cobrar
        $totalPublicasVencidas = Bill::whereHas('companyreceivable', function ($query) {
            $query->where('type', 'Pemex');
        })
            ->where('status', 'pendiente_cobrar')
            ->get()
            ->map(function ($bill) use ($dollarRate) {
                $expirationDate = Carbon::parse($bill->expiration_date);
                $today = Carbon::now();
                return $expirationDate->diffInDays($today, false) >= 0 ?
                    ($bill->companyreceivable->currency == 'MXN' ? $bill->total_payment / $dollarRate : $bill->total_payment) : 0;
            })->sum();

        // Monto total de las facturas no vencidas pendientes de cobrar (Públicas - Pemex)
        $totalPublicasNoVencidas = Bill::whereHas('companyreceivable', function ($query) {
            $query->where('type', 'Pemex');
        })
            ->where('status', 'pendiente_cobrar')
            ->get()
            ->map(function ($bill) use ($dollarRate) {
                $expirationDate = Carbon::parse($bill->expiration_date);
                $today = Carbon::now();
                // Facturas que NO están vencidas (expirarán en el futuro)
                return $expirationDate->diffInDays($today, false) < 0 ?
                    ($bill->companyreceivable->currency == 'MXN' ? $bill->total_payment / $dollarRate : $bill->total_payment) : 0;
            })->sum();

        // Facturas vencidas o por vencer

        $today = Carbon::now()->toDateString();

        $facturas = Bill::where('status', '=', 'pendiente_cobrar')
            ->whereHas('companyreceivable', function ($query) {
                // Otras condiciones si las necesitas
            })
            ->whereDate('expiration_date', '<=', $today) // Filtrar facturas vencidas directamente en la consulta
            ->paginate(20) // Paginar
            ->through(function ($bill) use ($today) {
                $expirationDate = Carbon::parse($bill->expiration_date);

                // Asignar el cálculo de días expirados
                $bill->diasExpirados = $expirationDate->diffInDays($today, false);
                return $bill;
            });


        return view('bill.index', compact(
            'totalPrivadasPendienteFacturar',
            'totalPrivadasVencidas',
            'totalPrivadasNoVencidas',
            'totalPublicasPendienteFacturar',
            'totalPublicasVencidas',
            'totalPublicasNoVencidas',
            'facturas'
        ));
    }

    //index donde se ven todas las facturas privadas al presionar la card de facturas
    public function facturasvencidasprivadas()
    {
        // Facturas vencidas
        $facturasprivvenc = Bill::where('status', '=', 'pendiente_cobrar')
            ->whereHas('companyreceivable', function ($query) {
                $query->where('type', 'Privada');
            })
            ->get()
            ->filter(function ($bill) {
                $expirationDate = Carbon::parse($bill->expiration_date);
                $today = Carbon::now();
                return $expirationDate->diffInDays($today, false) >= 0; // Facturas vencidas o por vencer
            })
            ->map(function ($bill) {
                $expirationDate = Carbon::parse($bill->expiration_date);
                $today = Carbon::now();
                $bill->diasExpirados = $expirationDate->diffInDays($today, false);
                return $bill;
            });

        return view('bill.vencidaspriv', compact('facturasprivvenc'));
    }

    //index donde se ven todas las facturas privadas al presionar la card de facturas
    public function facturasvencidaspublicas()
    {
        // Facturas vencidas
        $facturaspubvenc = Bill::where('status', '=', 'pendiente_cobrar')
            ->whereHas('companyreceivable', function ($query) {
                $query->where('type', 'Pemex');
            })
            ->get()
            ->filter(function ($bill) {
                $expirationDate = Carbon::parse($bill->expiration_date);
                $today = Carbon::now();
                return $expirationDate->diffInDays($today, false) >= 0; // Facturas vencidas o por vencer
            })
            ->map(function ($bill) {
                $expirationDate = Carbon::parse($bill->expiration_date);
                $today = Carbon::now();
                $bill->diasExpirados = $expirationDate->diffInDays($today, false);
                return $bill;
            });

        return view('bill.vencidaspublic', compact('facturaspubvenc'));
    }


    //index donde se ven todas las facturas privadas no vencidas al presionar la card de facturas
    public function facturasnovencidasprivadas()
    {
        // Facturas vencidas
        $facturasprivnov = Bill::where('status', '=', 'pendiente_cobrar')
            ->whereHas('companyreceivable', function ($query) {
                $query->where('type', 'Privada');
            })
            ->get()
            ->filter(function ($bill) {
                $expirationDate = Carbon::parse($bill->expiration_date);
                $today = Carbon::now();
                return $expirationDate->diffInDays($today, false) < 0; // Facturas vencidas o por vencer
            })
            ->map(function ($bill) {
                $expirationDate = Carbon::parse($bill->expiration_date);
                $today = Carbon::now();
                $bill->diasExpirados = $expirationDate->diffInDays($today, false);
                return $bill;
            });

        return view('bill.novencidaspriv', compact('facturasprivnov'));
    }



    //index donde se ven todas las facturas privadas no vencidas al presionar la card de facturas
    public function facturasnovencidaspublicas()
    {
        // Facturas vencidas
        $facturaspubnov = Bill::where('status', '=', 'pendiente_cobrar')
            ->whereHas('companyreceivable', function ($query) {
                $query->where('type', 'Pemex');
            })
            ->get()
            ->filter(function ($bill) {
                $expirationDate = Carbon::parse($bill->expiration_date);
                $today = Carbon::now();
                return $expirationDate->diffInDays($today, false) < 0; // Facturas vencidas o por vencer
            })
            ->map(function ($bill) {
                $expirationDate = Carbon::parse($bill->expiration_date);
                $today = Carbon::now();
                $bill->diasExpirados = $expirationDate->diffInDays($today, false);
                return $bill;
            });

        return view('bill.novencidaspublic', compact('facturaspubnov'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createFactura($companyreceivable_id)
    {
        //esto nos ayuda pasar el id a la vista
        $company = CompanyReceivable::findOrFail($companyreceivable_id);

        //pasamos los demas datos de esa empresa
        $bill = null;


        return view(
            'bill.create',
            [
                'company' => $company,
                'company_name' => $company->name,
                'company_type' => $company->type,
                'company_creditdays' => $company->creditdays
            ],
            compact('bill')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBillRequest $request, $companyreceivable_id)
    {
        $field = [];
    $message = ['required' => 'El :attribute es requerido'];

    $this->validate($request, $field, $message);
    $datosbill = $request->except('_token', 'diasexpirados');

    // Calcula la fecha de expiración
    $entryDate = Carbon::parse($request->input('entry_date')); // Fecha de entrada
    $company = CompanyReceivable::findOrFail($companyreceivable_id);
    $creditDays = $company->creditdays;

    $expirationDate = $entryDate->copy()->addDays($creditDays);

    // Guarda el valor de la fecha de expiración en formato para la base de datos
    $datosbill['expiration_date'] = $expirationDate;
    $datosbill['companyreceivable_id'] = $companyreceivable_id;

    Bill::insert($datosbill);

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
        $company = CompanyReceivable::findOrFail($companyreceivable_id);
        $bill = Bill::findOrFail($id);
    
        // Formato para expiration_date
        $bill->expiration_date = Carbon::parse($bill->expiration_date)->format('d-m-Y');
    
        return view(
            'bill.edit',
            [
                'company' => $company,
                'company_name' => $company->name,
                'company_type' => $company->type,
                'company_creditdays' => $company->creditdays,
                'bill' => $bill
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBillRequest $request, $companyreceivable_id, $id)
    {
        $datosbill = request()->except(['_token', 'diasexpirados', ('_method')]);
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

    
    public function exportEmpresas()
        {

            
        return Excel::download(new EmpresasExport, 'empresas.xlsx');
    }
}
