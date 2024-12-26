<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bill;
use App\Models\Currency;
use App\Mail\HelloWorldMail;
use App\Exports\EmpresasExport;
use App\Exports\ResumenSemanal;
use App\Models\CompanyReceivable;
use App\Exports\privadasNoVenExport;
use App\Exports\publicasNoVenExport;
use App\Exports\ResumenSemanaActual;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\pendienteCobrarGlobal;
use App\Exports\privadasvencidasExport;
use App\Exports\publicasVencidasExport;
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

        // **Totales empresas públicas (Pemex)**//////////////////////////////
        // Pendiente de facturar
        // Monto total de las facturas públicas pendientes de facturar
        $totalPublicasPendienteFacturar = Bill::whereHas('companyreceivable', function ($query) {
            $query->where('type', 'Pemex');
        })
            ->where('status', 'pendiente_facturar')
            ->get()
            ->map(function ($bill) use ($dollarRate) {
                // Determina la conversión según la moneda de la factura
                return $bill->currency === 'MXN' ? $bill->total_payment / $dollarRate : $bill->total_payment;
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

                // Facturas vencidas
                return $expirationDate->diffInDays($today, false) >= 0
                    ? ($bill->currency === 'MXN' ? $bill->total_payment / $dollarRate : $bill->total_payment)
                    : 0;
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

                // Facturas no vencidas
                return $expirationDate->diffInDays($today, false) < 0
                    ? ($bill->currency === 'MXN' ? $bill->total_payment / $dollarRate : $bill->total_payment)
                    : 0;
            })->sum();

        // Definir la fecha actual
        $today = Carbon::now();

        // Consulta de facturas vencidas
        $facturas = Bill::where('status', '=', 'pendiente_cobrar')
            ->whereHas('companyreceivable', function ($query) {
                $query->where('type', 'Privada');
            })
            ->get()
            ->filter(function ($bill) use ($today) {
                // Filtrar facturas vencidas o por vencer
                $expirationDate = Carbon::parse($bill->expiration_date);
                return $expirationDate->diffInDays($today, false) >= 0;
            })
            ->map(function ($bill) use ($today) {
                // Asignar el cálculo de días expirados
                $expirationDate = Carbon::parse($bill->expiration_date);
                $bill->diasExpirados = $expirationDate->diffInDays($today, false);

                // Asegurarse de devolver $bill
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

        $currencyOptions = $company->currency === 'MIXTA'
            ? ['USD', 'MXN'] // Opciones para empresas mixtas
            : [$company->currency]; // Solo la moneda configurada


        return view(
            'bill.create',
            [
                'company' => $company,
                'company_name' => $company->name,
                'company_type' => $company->type,
                'company_creditdays' => $company->creditdays
            ],
            compact('bill', 'company', 'currencyOptions')
        );
    }
    public function store(StoreBillRequest $request, $companyreceivable_id)
    {
        $field = [];
        $message = ['required' => 'El :attribute es requerido'];

        $this->validate($request, $field, $message);
        $datosbill = $request->except('_token', 'diasexpirados','diascredito');

        // Obtener la empresa para verificar su nombre y tipo
        $company = CompanyReceivable::findOrFail($companyreceivable_id);

        // Validar y asignar la divisa
        if ($company->currency === 'MIXTA') {
            $datosbill['currency'] = $request->input('currency');
        } else {
            $datosbill['currency'] = $company->currency;
        }

        // Verificar si entry_date es null y la empresa cumple las condiciones
        if ($request->input('entry_date') === null && $company->name === 'GSM BRONCO') {
            $datosbill['status'] = 'pendiente_entrada';
            $datosbill['expiration_date'] = null; // Asegúrate de establecer la expiración a null si no hay fecha de entrada
        } else {
            // Calcula la fecha de expiración usando el valor del input `diascredito`
        $entryDate = Carbon::parse($request->input('entry_date'));
        $creditDays = (int) $request->input('diascredito'); // Tomamos el valor del input
        $expirationDate = $entryDate->copy()->addDays($creditDays);

            // Guarda el valor de la fecha de expiración en el formato adecuado para la base de datos
            $datosbill['expiration_date'] = $expirationDate;
        }

        // Verifica si la empresa es pública, se llama "PEMEX CONTRATO TOMS  646203854", y el porcentaje es true
        if ($company->type === 'Pemex' && $company->name === 'PEMEX CONTRATO TOMS  646203854' && $request->input('porcent') === true) {
            $datosbill['total_payment'] = $request->input('total_payment') * 0.2;
        } else {
            $datosbill['total_payment'] = $request->input('total_payment');
        }

        $datosbill['companyreceivable_id'] = $companyreceivable_id;

        Bill::insert($datosbill);

        return redirect()->route('empresas.show', $companyreceivable_id)->with('message', 'Factura creada exitosamente');
    }

    public function update(UpdateBillRequest $request, $companyreceivable_id, $id)
    {
        $datosbill = $request->except(['_token', 'diasexpirados', '_method','diascredito']);

        // Obtener la empresa para verificar su nombre y tipo
        $company = CompanyReceivable::findOrFail($companyreceivable_id);


        // Verificar si entry_date es null y la empresa cumple las condiciones
        if ($request->input('entry_date') === null && $company->name === 'GSM BRONCO') {
            $datosbill['status'] = 'pendiente_entrada';
            $datosbill['expiration_date'] = null; // Asegúrate de establecer la expiración a null si no hay fecha de entrada
        } else {
             // Calcula la fecha de expiración usando el valor del input `diascredito`
        $entryDate = Carbon::parse($request->input('entry_date'));
        $creditDays = (int) $request->input('diascredito'); // Tomamos el valor del input
        $expirationDate = $entryDate->copy()->addDays($creditDays);

            // Actualiza la fecha de expiración en los datos de la factura
            $datosbill['expiration_date'] = $expirationDate;
        }

        // Verifica si la empresa es pública, se llama "PEMEX CONTRATO TOMS  646203854", y el porcentaje es true
        if ($company->type === 'Pemex' && $company->name === 'PEMEX CONTRATO TOMS  646203854' && $request->input('porcent') === true) {
            $datosbill['total_payment'] = $request->input('total_payment') * 0.2;
        } else {
            $datosbill['total_payment'] = $request->input('total_payment');
        }

        // Actualiza la factura en la base de datos
        Bill::where('id', $id)->update($datosbill);

        // Redirige al perfil de la empresa
        return redirect()->route('empresas.show', $companyreceivable_id)->with('message', 'Factura actualizada exitosamente');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($companyreceivable_id, $id)
    {
        $company = CompanyReceivable::findOrFail($companyreceivable_id);
        $bill = Bill::findOrFail($id);

        $creditDays = (int) request()->input('diascredito', 0); // Tomar 'diascredito' si está presente

        if ($bill->entry_date && $creditDays) {
            $expirationDate = Carbon::parse($bill->entry_date)->addDays($creditDays)->format('Y-m-d');
        } else {
            $expirationDate = $bill->expiration_date ? Carbon::parse($bill->expiration_date)->format('Y-m-d') : null;
        }


        $currencyOptions = $company->currency === 'MIXTA'
            ? ['USD', 'MXN'] // Opciones para empresas mixtas
            : [$company->currency]; // Solo la moneda configurada

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
            ],
            compact('company', 'currencyOptions','expirationDate')
        );
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


        return Excel::download(new EmpresasExport, 'Información General ' . Carbon::now()->format('d-m-Y') . '.xlsx');
    }

    public function exportPrivadasVencidas()
    {
        return Excel::download(new privadasvencidasExport, 'Privadas_Vencidas ' . Carbon::now()->format('d-m-Y') . '.xlsx');
    }

    public function exportPrivadasNoVencidas()
    {
        return Excel::download(new privadasNoVenExport, 'Privadas_NO_Vencidas ' . Carbon::now()->format('d-m-Y') . '.xlsx');
    }

    public function exportPublicasVencidas()
    {
        return Excel::download(new publicasVencidasExport, 'Pemex_Vencidas ' . Carbon::now()->format('d-m-Y') . '.xlsx');
    }

    public function exportPublicasNoVencidas()
    {
        return Excel::download(new publicasNoVenExport, 'Pemex_NO_Vencidas' . Carbon::now()->format('d-m-Y') . '.xlsx');
    }

    public function exportpendienteCobrarGlobal()
    {
        return Excel::download(new pendienteCobrarGlobal, 'Pendientes Por Cobrar al ' . Carbon::now()->format('d-m-Y') . '.xlsx');
    }

    public function exportReporteSemanal()
    {
        return Excel::download(new ResumenSemanal, 'Resumen Semanal ' . Carbon::now()->format('d-m-Y') . '.xlsx');
    }

    public function exportReporteSemanaActual()
    {
        return Excel::download(new ResumenSemanaActual, 'Resumen Semana actual ' . Carbon::now()->format('d-m-Y') . '.xlsx');
    }

    public function sendHelloWorldEmail()
    {
        Mail::to('digital@hothedmex.mx')->send(new HelloWorldMail());
        return 'Correo enviado con éxito';
    }
}
