<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bill;
use App\Models\CompanyReceivable;
use App\Exports\EmpresaSheetExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreCompanyReceivableRequest;
use App\Http\Requests\UpdateCompanyReceivableRequest;

class CompanyReceivableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datos['Companies'] = CompanyReceivable::paginate(30);
        return view('companiesreceivable.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $company = null;
        $currency = null;
        return view('companiesreceivable.create', compact('company', 'currency'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyReceivableRequest $request)
    {
        $field = ['name' => 'required', 'type' => 'required', 'currency' => 'required'];
        $message = ['required' => 'El :attribute es requerido'];

        $this->validate($request, $field, $message);

        $datoscompany = $request->except('_token');
        CompanyReceivable::insert($datoscompany);

        return redirect('empresas')->with('message', 'Empresa agregada');
    }

    /**
     * Display the specified resource.
     */
    public function show(CompanyReceivable $companyReceivable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $company = CompanyReceivable::FindOrFail($id);
        return view('companiesreceivable.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyReceivableRequest $request, $id)
    {
        $datoscompany = request()->except(['_token', ('_method')]);
        CompanyReceivable::where('id', $id)->update($datoscompany);
        $company = CompanyReceivable::FindOrFail($id);

        return redirect('empresas')->with('message', 'Empresa Actualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //CompanyReceivable::destroy($id);
        //return redirect('empresas');
    }

    // Mostrar el catálogo de empresas privadas
    public function indexprivate()
    {
        // Obtén las empresas privadas
        $empresasPrivadas = CompanyReceivable::where('type', 'Privada')->get();

        // Verifica que hay registros
        if ($empresasPrivadas->isEmpty()) {
            abort(404, 'No hay empresas privadas registradas.');
        }

        return view('companiesreceivable.indexprivate', compact('empresasPrivadas'));
    }

    // Mostrar el catálogo de empresas públicas
    public function indexPublicas()
    {
        $empresasPublicas = CompanyReceivable::where('type', 'Pemex')->get();
        return view('companiesreceivable.indexpublic', compact('empresasPublicas'));
    }

    // Mostrar los detalles de una empresa seleccionada
    public function showEmpresa($id)
    {
        $empresa = CompanyReceivable::with('bills')->findOrFail($id);

        $unpaidBills = $empresa->bills
            ->whereIn('status', ['pendiente_facturar', 'pendiente_cobrar','pendiente_entrada'])
            ->sortBy(function ($bill) {
                return $bill->status === 'pendiente_facturar' ? 0 : 1;
            });

        // Calcular los totales
        //$totalGlobal = $empresa->bills->where('status', '!=', 'cancelado')->sum('total_payment');
        $totalGlobal = $empresa->bills
    ->whereNotIn('status', ['cancelado', 'pendiente_facturar'])
    ->sum('total_payment');
        $totalPendienteFacturar = $empresa->bills->where('status', 'pendiente_facturar')->sum('total_payment');
        $totalPendienteCobrar = $empresa->bills->where('status', 'pendiente_cobrar')->sum('total_payment');
        $totalPagado = $empresa->bills->where('status', 'pagado')->sum('total_payment');

        return view('companiesreceivable.detail', compact(
            'empresa',
            'totalGlobal',
            'totalPendienteFacturar',
            'totalPendienteCobrar',
            'totalPagado',
            'unpaidBills'
        ));
    }

    public function history($company_id)
    {
        $comp = CompanyReceivable::findOrFail($company_id);

        // Filtrar facturas por empresa y agrupar por año, mes y estado
        $bills = Bill::where('companyreceivable_id', $company_id)
            ->selectRaw(
                'YEAR(billing_date) as year,
                    MONTH(billing_date) as month,
                    status,
                    SUM(total_payment) as total'
            )
            ->groupBy('year', 'month', 'status')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Crear un array para almacenar el desglose por mes-año y estado
        $grupofacturas = [];

        // Rellenar los datos por cada mes y estado
        foreach ($bills as $bill) {
            // Formatear el mes y año
            $monthYear = Carbon::create($bill->year, $bill->month, 1)->format('M-Y');

            // Inicializar el mes y año en el arreglo si no existe
            if (!isset($grupofacturas[$monthYear])) {
                $grupofacturas[$monthYear] = [
                    'pendiente_facturar' => 0,
                    'pagado' => 0,
                    'pendiente_cobrar' => 0,
                ];
            }

            // Asignar el total a la categoría correspondiente según el status
            switch ($bill->status) {
                case 'pendiente_facturar':
                    $grupofacturas[$monthYear]['pendiente_facturar'] = $bill->total;
                    break;
                case 'pagado':
                    $grupofacturas[$monthYear]['pagado'] = $bill->total;
                    break;
                case 'pendiente_cobrar':
                    $grupofacturas[$monthYear]['pendiente_cobrar'] = $bill->total;
                    break;
            }
        }

        return view('companiesreceivable.history', compact('grupofacturas', 'comp'));
    }





    public function paid($company_id)
    {

        $comp = CompanyReceivable::findOrFail($company_id);

        //obtener solo las facturas con status "pagado"

        $paidBills = Bill::where('companyreceivable_id', $company_id)
            ->where('status', 'pagado')
            ->get();


        return view('companiesreceivable.paid', compact('paidBills', 'comp'));
    }


    public function exportEmpresaExcel($id)
    {
        $empresa = CompanyReceivable::findOrFail($id);
        return Excel::download(new EmpresaSheetExport($empresa), 'empresa_' . $empresa->name . '.xlsx');
    }


}
