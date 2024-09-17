<?php

namespace App\Http\Controllers;

use App\Models\Typemaint;
use App\Http\Requests\StoreTypemaintRequest;
use App\Http\Requests\UpdateTypemaintRequest;

class TypemaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typemaint=Typemaint::paginate(5);
        return view('typemaint.index', compact('typemaint'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('typemaint.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTypemaintRequest $request)
    {
        $field=['maintenance'=>'required'];
        $mesagge=['required'=>'El :attribute es requerido'];
        $this->validate($request, $field, $mesagge);
        $datostypemaint=$request->except('_token');
        Typemaint::insert($datostypemaint);

        return redirect('tiposmantenimiento')->with('message','Tipo de mantenimiento agregado');
    }

    /**
     * Display the specified resource.
     */
    public function show(Typemaint $typemaint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $typemaint=Typemaint::FindOrFail($id);
        return view('typemaint.edit',compact('typemaint'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTypemaintRequest $request, $id)
    {
        $datostypemaint=request()->except(['_token',('_method')]);
        Typemaint::where('id',$id)->update($datostypemaint);
        $typemaint=Typemaint::FindOrFail($id);
        return redirect ('tiposmantenimiento')->with('message', 'Tipo de mantenimiento actualizado');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Typemaint::destroy($id);
        return redirect('tiposmantenimiento/');
    }
}
