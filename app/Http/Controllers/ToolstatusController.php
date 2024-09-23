<?php

namespace App\Http\Controllers;

use App\Models\Toolstatus;
use App\Http\Requests\StoreToolstatusRequest;
use App\Http\Requests\UpdateToolstatusRequest;

class ToolstatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $toolstatus=Toolstatus::paginate(5);
        return view('toolstatus.index', compact('toolstatus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('toolstatus.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreToolstatusRequest $request)
    {
        $field=['status'=>'required'];
        $message=['required'=> 'El :attribute es requerido'];
        $this->validate($request, $field, $message);

        $datostoolstatus=$request->except('_token');
        Toolstatus::insert($datostoolstatus);

        return redirect('toolstatus')->with('message','Status de herramienta agregado');

    }

    /**
     * Display the specified resource.
     */
    public function show(Toolstatus $toolstatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $toolstatus=Toolstatus::FindOrFail($id);
        return view('toolstatus.edit', compact('toolstatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateToolstatusRequest $request, $id)
    {
        $datostoolstatus=request()->except(['_token', ('_method')]);
        Toolstatus::where('id',$id)->update($datostoolstatus);
        $toolstatus=Toolstatus::FindOrFail($id);
        return redirect('toolstatus')->with('message', 'Status de herramienta actualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Toolstatus::destroy($id);
        return redirect('toolstatus');
    }
}
