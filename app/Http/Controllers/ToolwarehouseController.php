<?php

namespace App\Http\Controllers;

use App\Models\Toolwarehouse;
use App\Models\Family;
use App\Models\Subgroup;
use App\Models\Base;
use App\Models\Toolstatus;
use App\Http\Requests\StoreToolwarehouseRequest;
use App\Http\Requests\UpdateToolwarehouseRequest;

class ToolwarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $toolwarehouse=Toolwarehouse::with(['toolstatus:id,status','subgroup:id,name','family:id,name','base:id,name'])
        ->paginate(30);
        $toolstatus=Toolstatus::all();
        $subgroups=Subgroup::all();
        $families=Family::all();
        $bases=Base::all();
        return view('toolwarehouse.index', 
        compact('toolwarehouse','toolstatus','subgroups','families','bases'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $families=Family::select('id','name')->get();
        $subgroups=Subgroup::select('id','name')->get();
        $bases=Base::select('id','name')->get();
        $toolstatus=Toolstatus::select('id','status')->get();
        return view('toolwarehouse.create', compact('families','subgroups','bases','toolstatus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreToolwarehouseRequest $request)
    {
        $field=['family_id'=>'required', 
                'subgroup_id'=>'required', 
                'description'=>'required', 
                'serienum'=>'required', 
                'extdia'=>'required', 
                'length'=>'required', 
                'toolstatus_id'=>'required',
                'base_id' =>'required'];
        $message=['required'=> 'El :attribute es requerido'];
        $this->validate($request, $field, $message);

        $datostoolwarehouse=$request->except('_token');
        Toolwarehouse::insert($datostoolwarehouse);

        return redirect('almacenherramientas')->with('message','Herramienta agregada');
    }

    /**
     * Display the specified resource.
     */
    public function show(Toolwarehouse $toolwarehouse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $toolwarehouse=Toolwarehouse::FindOrFail($id);
        $families=Family::select('id','name')->get();
        $subgroups=Subgroup::select('id','name')->get();
        $bases=Base::select('id','name')->get();
        $toolstatus=Toolstatus::select('id','status')->get();
        return view('toolwarehouse.edit', compact('toolwarehouse', 'families', 'subgroups','bases', 'toolstatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateToolwarehouseRequest $request, $id)
    {

        $field=['family_id'=>'required', 
                'subgroup_id'=>'required', 
                'description'=>'required', 
                'serienum'=>'required', 
                'extdia'=>'required', 
                'length'=>'required', 
                'toolstatus_id'=>'required',
                'base_id' =>'required'];
        $message=['required'=> 'El :attribute es requerido'];
        $this->validate($request, $field, $message);

        $datostoolwarehouse=request()->except(['_token', ('_method')]);
        Toolwarehouse::where('id',$id)->update($datostoolwarehouse);
        $toolwarehouse=Toolwarehouse::FindOrFail($id);
        return redirect('almacenherramientas')->with('message', 'Herramienta actualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Toolwarehouse $toolwarehouse)
    {
        //
    }
}
