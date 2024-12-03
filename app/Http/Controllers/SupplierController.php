<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datos ['Suppliers'] = Supplier::paginate(30);
        return view ('supplier.index',$datos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $field = ['name'=>'required','rfc'=>'required', 'critic'=>'required', 'currency'=>'required','single_supplier'=>'required',];
        $message = ['required' => 'El :attribute es requerido'];
        
        $this->validate($request, $field, $message);
        $datossupplier=$request->except('_token');

        Supplier::insert($datossupplier);

        return redirect ('proveedores')->with('message','Proveedor agregado');
    }

  
    public function edit($id)
    {
        $supplier = Supplier::FindOrFail($id);

        return view('supplier.edit',compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $field = ['name'=>'required','rfc'=>'required', 'critic'=>'required', 'currency'=>'required','single_supplier'=>'required',];
        $message = ['required' => 'El :attribute es requerido'];
         $this->validate($request, $field, $message);

        $datossupplier = request()->except(['_token',('_method')]);
        Supplier::where('id',$id)->update($datossupplier);
       // $supplier = Supplier::FindOrFail($id);

        return redirect('proveedores')->with('message','Proveedor Actualizado');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        //
    }
}
