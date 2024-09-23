<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Http\Requests\StoreBaseRequest;
use App\Http\Requests\UpdateBaseRequest;

class BaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $base=Base::paginate(5);
        return view('base.index', compact('base'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('base.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBaseRequest $request)
    {
        $field=['name'=>'required'];
        $message=['required'=> 'El :attribute es requerido'];
        $this->validate($request, $field, $message);

        $datosbase=$request->except('_token');
        Base::insert($datosbase);

        return redirect('bases')->with('message','Base agregada');
    }

    /**
     * Display the specified resource.
     */
    public function show(Base $base)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $base=Base::FindOrFail($id);
        return view('base.edit', compact('base'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBaseRequest $request, $id)
    {
        $datosbase=request()->except(['_token', ('_method')]);
        Base::where('id',$id)->update($datosbase);
        $base=Base::FindOrFail($id);
        return redirect('bases')->with('message','Base actualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Base::destroy($id);
        return redirect('bases/');
    }
}
