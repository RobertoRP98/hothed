<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Http\Requests\StoreStatusRequest;
use App\Http\Requests\UpdateStatusRequest;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $datos['Statuses'] = Status::paginate(5);
        return view('status.index',$datos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('status.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStatusRequest $request)
    {
            // Reglas y mensajes personalizados.
    $field = ['status' => 'required'];
    $message = ['required' => 'El :attribute es requerido'];

    // Validar la solicitud.
    $this->validate($request, $field, $message);  

    // Procesar los datos y guardar el cliente.
    $datosstatus = $request->except('_token');
    Status::insert($datosstatus);

    // Redirigir con mensaje de éxito.
    return redirect('status')->with('message', 'Status agregado');
    }

    /**
     * Display the specified resource.
     */
    public function show(Status $status)
    {
        return view();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $status=Status::FindOrFail($id);
        return view('status.edit', compact('status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStatusRequest $request, $id)
    {
        $datosstatus=request()->except(['_token',('_method')]);
        Status::where('id',$id)->update($datosstatus);
        $client=Status::FindOrFail($id);
        return redirect('status')->with('message','Status Actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Status::destroy($id);
        return redirect('status/');
    }
}
