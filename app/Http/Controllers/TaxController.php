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
        return view ('tax.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaxRequest $request)
    {
        $field = ['name' => 'required', 'percent' => 'required'];
        $message = ['required' => 'El :attribute es requerido'];

        $this->validate($request, $field, $message);

        $datostax = $request->except('_token');
        Tax::insert($datostax);

        return redirect ('impuestos')->with('message','Concepto agregado'); 
    }

    public function edit($id)
    {
        $tax = Tax::FindOrFail($id);
        return view('tax.edit',compact('tax'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaxRequest $request, $id)
    {
        $datostax = request()->except(['_token',('_method')]);
        Tax::where('id',$id)->update($datostax);
        $tax = Tax::FindOrFail($id);

        return redirect('impuestos')->with('message','Concepto Actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tax $tax)
    {
        //
    }
}
