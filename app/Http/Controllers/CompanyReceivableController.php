<?php

namespace App\Http\Controllers;

use App\Models\CompanyReceivable;
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
        return view('companiesreceivable.index',$datos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $company=null;
        $currency=null;
        return view('companiesreceivable.create', compact('company','currency'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyReceivableRequest $request)
    {
        $field = ['name' => 'required', 'type' => 'required', 'currency' => 'required' ];
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
        $company=CompanyReceivable::FindOrFail($id);
        return view('companiesreceivable.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyReceivableRequest $request, $id)
    {
        $datoscompany=request()->except(['_token',('_method')]);
        CompanyReceivable::where('id',$id)->update($datoscompany);
        $company=CompanyReceivable::FindOrFail($id);

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

        // Calcular los totales
        $totalGlobal = $empresa->bills->sum('total_payment');
        $totalPendienteFacturar = $empresa->bills->where('status', 'pendiente_facturar')->sum('total_payment');
        $totalPendienteCobrar = $empresa->bills->where('status', 'pendiente_cobrar')->sum('total_payment');
        $totalPagado = $empresa->bills->where('status', 'pagado')->sum('total_payment');

        return view('companiesreceivable.detail', compact('empresa', 'totalGlobal', 'totalPendienteFacturar', 'totalPendienteCobrar', 'totalPagado'));
    }
}
