<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datos ['Products'] = Product::paginate(30);
        return view ('product.index',$datos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $impuestos = Tax::all();
        return view ('product.create', compact('impuestos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $field = ['name'=>'required',
        'udm'=>'required',
        'category'=>'required',
        'precio'=>'required',
        ];
        $message = ['required'=> 'El :attribute es requerido'];

        $this->validate($request, $field, $message);
        $datosproduct=$request->except('_token');

        Product::insert($datosproduct);

        return redirect('productos')->with('message','Producto Agregado');

    }

    public function edit($id)
    {
        $product = Product::FindOrFail($id);
        $impuestos = Tax::all();

        return view ('product.edit',compact('product','impuestos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $field = ['name'=>'required',
        'udm'=>'required',
        'category'=>'required',
        'precio'=>'required',
        ];
        $message = ['required'=> 'El :attribute es requerido'];
        $this->validate($request, $field, $message);

        $datosproduct = request()->except(['token',('_method')]);
        Product::where('id',$id)->update($datosproduct);

        return redirect('productos')->with('message','Producto Actualizado');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
