<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkstationRequest;
use App\Http\Requests\UpdateWorkstationRequest;
use App\Models\Workstation;

class WorkstationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workstations = Workstation::paginate(30);

        return view('modulo-documentos.workstation.index', compact('workstations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('modulo-documentos.workstation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkstationRequest $request)
    {
        $datosworkstation = $request->validated();

        Workstation::create($datosworkstation);

        return redirect('puestos-trabajo')->with('message','Puesto de trabajo creado');
    }

    /**
     * Display the specified resource.
     */
    public function show(Workstation $workstation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $workstation = Workstation::FindOrFail($id);

        return view('modulo-documentos.workstation.edit', compact('workstation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkstationRequest $request, $id)
    {
        $datosworkstation = $request->validated();
        Workstation::where('id',$id)->update($datosworkstation);

        return redirect('puestos-trabajo')->with('message','Puesto de trabajo actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workstation $workstation)
    {
        //
    }
}
