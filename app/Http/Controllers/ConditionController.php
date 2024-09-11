<?php

namespace App\Http\Controllers;

use App\Models\Condition;
use App\Http\Requests\StoreConditionRequest;
use App\Http\Requests\UpdateConditionRequest;

class ConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Conditions = Condition::paginate(5);
        return view('condition.index', compact('Conditions'));
    }
   

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('condition.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreConditionRequest $request)
    {
        $field=['condition'=>'required'];
        $message = ['required'=> 'El :attribute es requerido'];

        $this->validate($request, $field, $message);

        $datoscondition=$request->except('_token');
        Condition::insert($datoscondition);

        return redirect('condiciones')->with('message','Condicion agregada');
    }

    /**
     * Display the specified resource.
     */
    public function show(Condition $condition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $condition=Condition::FindOrFail($id);
        return view('condition.edit', compact('condition'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConditionRequest $request, $id)
    {
        $datoscondition=request()->except(['_token',('_method')]);
        Condition::where('id',$id)->update($datoscondition);
        $condition=Condition::FindOrFail($id);
        return redirect('condiciones')->with('message','Condicion actualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Condition::destroy($id);
        return redirect ('condiciones/');
    }
}
