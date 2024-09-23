<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Http\Requests\StoreFamilyRequest;
use App\Http\Requests\UpdateFamilyRequest;

class FamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $family=Family::paginate(5);
        return view('family.index', compact('family'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('family.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFamilyRequest $request)
    {
        $field=['name'=>'required'];
        $message=['required'=>'El :attribute es requerido'];
        $this->validate($request, $field, $message);

        $datosfamily=$request->except('_token');
        Family::insert($datosfamily);

        return redirect('familias')->with('message', 'Familia agregada');
    }

    /**
     * Display the specified resource.
     */
    public function show(Family $family)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $family=Family::FindOrFail($id);
        return view('family.edit',compact('family'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFamilyRequest $request, $id)
    {
        $datosfamily=request()->except(['_token',('_method')]);
        Family::where('id',$id)->update($datosfamily);
        $family=Family::FindOrFail($id);
        return redirect('familias')->with('message','Familia actualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Family::destroy($id);
        return redirect('familias/');
    }
}
