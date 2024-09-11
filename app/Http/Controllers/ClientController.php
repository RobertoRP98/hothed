<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datos['Clients'] = Client::paginate(5);
        return view('client.index',$datos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('client.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {


       // Reglas y mensajes personalizados.
    $field = ['name' => 'required'];
    $message = ['required' => 'El :attribute es requerido'];

    // Validar la solicitud.
    $this->validate($request, $field, $message);  

    // Procesar los datos y guardar el cliente.
    $datosclient = $request->except('_token');
    Client::insert($datosclient);

    // Redirigir con mensaje de éxito.
    return redirect('clientes')->with('message', 'Cliente agregado');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return view();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {   
        $client=Client::FindOrFail($id);
        return view('client.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, $id)
    {
        $datosclient=request()->except(['_token',('_method')]);
        Client::where('id',$id)->update($datosclient);
        $client=Client::FindOrFail($id);
        //return view('client.edit', compact('client'));
        return redirect('clientes')->with('message','Cliente Actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Client::destroy($id);
        return redirect('clientes/');
    }
}
