<?php

namespace App\Http\Controllers;

use App\Models\Well_oil;
use App\Http\Requests\StoreWell_oilRequest;
use App\Http\Requests\UpdateWell_oilRequest;

class WellOilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Welloil=Well_oil::paginate(5);
        return view('welloil.index', compact('Welloil'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('welloil.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWell_oilRequest $request)
    {
        $field=['name'=>'required', 'located'=>'required'];
        $message = ['required'=> 'El :attribute es requerido'];

        $this->validate($request, $field, $message);

        $datoswelloil=$request->except('_token');
        Well_oil::insert($datoswelloil);

        return redirect('pozos')->with('message','Pozo agregado');
    }

    /**
     * Display the specified resource.
     */
    public function show(Well_oil $well_oil)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $welloil=Well_oil::FindOrFail($id);
        return view('welloil.edit',compact('welloil'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWell_oilRequest $request, $id)
    {
        $datoswelloil=request()->except(['_token',('_method')]);
        Well_oil::where('id',$id)->update($datoswelloil);
        $well_oil=Well_oil::FindOrFail($id);
        return redirect ('pozos')->with('message','Pozo actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Well_oil::destroy($id);
        return redirect ('pozos/');
    }
}
