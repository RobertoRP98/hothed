<?php

namespace App\Http\Controllers;

use App\Models\RequisBeta;
use App\Http\Requests\StoreRequisBetaRequest;
use App\Http\Requests\UpdateRequisBetaRequest;

class RequisBetaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datos['requisiciones'] = RequisBeta::all();
        return view('requisbeta.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('requisbeta.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequisBetaRequest $request)
    {
        $datosrequi = $request->validated();

        RequisBeta::create($datosrequi);

        return redirect('requisiciones-beta')->with('message', 'Requisición Agregada');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $requi = RequisBeta::FindOrFail($id);
        return view('requisbeta.edit', compact('requi'));
    }

    /**
     * Update the specified resource in storage.
     */


    public function update(UpdateRequisBetaRequest $request, RequisBeta $requisBeta)
    {
        $requisBeta->update($request->validated()); // Actualiza con datos validados
        return redirect()->route('requisiciones-beta.index')->with('message', 'Requisición actualizada');
    }



    //REQUIS DE ADMINISTRACIÓN
    public function indexadm()
    {

        if ((auth()->user()->departament !== 'ADM' && !auth()->user()->hasRole('Developer'))
            || (auth()->user()->departament === 'ADM' && auth()->user()->area === 'SGI')
        ) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }

        $requisitionadm = RequisBeta::where('dep_soli', 'ADMINISTRACION')
            ->get();
        return view('requisbeta.indexadmin', compact('requisitionadm'));
    }

    //REQUIS DE OPERACIONES
    public function indexope()
    {
        if ((auth()->user()->departament !== 'OP' && !auth()->user()->hasRole('Developer'))
            || (auth()->user()->departament === 'ADM' && auth()->user()->area === 'SGI')
        ) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }

        $requisitionope = RequisBeta::where('dep_soli', 'OPERACIONES')
            ->get();
        return view('requisbeta.indexope', compact('requisitionope'));
    }

    //REQUIS DE SGI
    public function indexsgi()
    {
        // Verificar explícitamente que el usuario tiene el rol correcto
        if (auth()->user()->area !== 'SGI' && !auth()->user()->hasRole('Developer')) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }
        $requisitionsgi = RequisBeta::where('dep_soli', 'SGI')
            ->get();
        return view('requisbeta.indexsgi', compact('requisitionsgi'));
    }
}
