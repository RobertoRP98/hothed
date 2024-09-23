<?php

namespace App\Http\Controllers;

use App\Models\Subgroup;
use App\Http\Requests\StoreSubgroupRequest;
use App\Http\Requests\UpdateSubgroupRequest;

class SubgroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subgroup=Subgroup::paginate(5);
        return view('subgroup.index', compact('subgroup'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('subgroup.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubgroupRequest $request)
    {
        $field=['name'=>'required'];
        $message=['required'=>'El :attribute es requerido'];
        $this->validate($request, $field, $message);

        $datossubgroup=$request->except('_token');
        Subgroup::insert($datossubgroup);

        return redirect('subgrupos')->with('message','Subgrupo agreado');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subgroup $subgroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $subgroup=Subgroup::FindOrFail($id);
        return view('subgroup.edit', compact('subgroup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubgroupRequest $request, $id)
    {
        $datossubgroup=request()->except(['_token',('_method')]);
        Subgroup::where('id',$id)->update($datossubgroup);
        $subgroup=Subgroup::FindOrFail($id);
        return redirect('subgrupos')->with('message','Subgrupo actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Subgroup::destroy($id);
        return redirect('subgrupos/');
    }
}
