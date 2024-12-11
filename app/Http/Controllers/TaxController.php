<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use App\Http\Requests\StoreTaxRequest;
use App\Http\Requests\UpdateTaxRequest;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datos ['taxes'] = Tax::paginate(30);
        return view ('tax.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tax.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaxRequest $request)
    {
        $datostax = $request->validated();

        Tax::create($datostax);

        return redirect('impuestos')->with('message','Impuesto Creado');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tax $tax)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tax = Tax::FindOrFail($id);
        return view('tax.edit', compact('tax'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaxRequest $request, $id)
    {   
        $datostax = $request->validated();
        Tax::where('id', $id)->update($datostax);
        //$tax = Tax::FindOrFail($id);
        return redirect('impuestos')->with('message','Impuesto Actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tax $tax)
    {
        //
    }
}
