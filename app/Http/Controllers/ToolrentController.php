<?php

namespace App\Http\Controllers;

use App\Models\Toolrent;
use App\Http\Requests\StoreToolrentRequest;
use App\Http\Requests\UpdateToolrentRequest;

class ToolrentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $toolrent=Toolrent::paginate(5);
        return view('toolrent.index',compact('toolrent'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('toolrent.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreToolrentRequest $request)
    {
        $field=['serienumber'=>'required', 'description'=>'required'];
        $message= ['required'=> 'El :attribute es requerido'];
        $this->validate($request, $field, $message);
        $datostoolrent=$request->except('_token');
        Toolrent::insert($datostoolrent);

        return redirect('herramientasrenta')->with('message','Herramienta agregada');
    }

    /**
     * Display the specified resource.
     */
    public function show(Toolrent $toolrent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $toolrent=Toolrent::FindOrFail($id);
        return view('toolrent.edit',compact('toolrent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateToolrentRequest $request, $id)
    {
        $datostoolrent=request()->except(['_token',('_method')]);
        Toolrent::where('id',$id)->update($datostoolrent);
        $toolrent=Toolrent::FindOrFail($id);
        return redirect ('herramientasrenta')->with('message','Herramenta actualizada');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Toolrent::destroy($id);
        return redirect ('herramientasrenta/');
    }
}
