<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Http\Requests\StoreCurrencyRequest;
use App\Http\Requests\UpdateCurrencyRequest;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currency=Currency::paginate(10);
        return view('currency.index', compact('currency'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('currency.create');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCurrencyRequest $request)
    {
        $field=['currency'=>'required', 'rate'=>'required'];
        $message=['required'=>'El :attribute es requerido'];
        $this->validate($request, $field, $message);

        $datoscurrency=$request->except('_token');
        Currency::insert($datoscurrency);

        return redirect('divisas')->with('message', 'Divisa agregada');
    }

    /**
     * Display the specified resource.
     */
    public function show(Currency $currency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $currency=Currency::FindOrFail($id);
        return view('currency.edit',compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCurrencyRequest $request, $id)
    {
        $datoscurrency=request()->except(['_token',('_method')]);
        Currency::where('id',$id)->update($datoscurrency);
        $currency=Currency::FindOrFail($id);
        return redirect('divisas')->with('message','Divisa actualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Currency $currency)
    {
        //
    }
}
