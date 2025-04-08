<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use Illuminate\Http\Request;


class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datos ['suppliers'] = Supplier::all();
        return view('supplier.index',$datos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        $datossupplier = $request->validated();

        Supplier::create($datossupplier);

        return redirect ('proveedores')->with('message', 'Proveedor Creado');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $supplier = Supplier::FindOrFail($id);

        return view('supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, $id)
    {
        $datossupplier = $request->validated();

        $supplier= Supplier::findOrFail($id);

        $supplier->fill($datossupplier);

        $supplier->setAttributesToUppercase(['name','rfc','address','account']);

        $supplier->save();


        return redirect('proveedores')->with('message','Proveedor Actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        //
    }

    public function search(Request $request){

        // Recuperamos el término de búsqueda enviado por el frontend
     $query = $request->input('query'); // Aquí usamos 'query' para que coincida con el frontend
 
     // Si no hay término de búsqueda, devolver un array vacío
     if (!$query) {
         return response()->json([]);
     }
 
     // Realizamos la búsqueda en la base de datos
     $supplier = Supplier::where('name', 'like', '%' . $query . '%')
         ->orderBy('name', 'asc') // Opcional, ordena alfabéticamente
         ->get();
 
     // Devolvemos los resultados como respuesta JSON
     return response()->json($supplier);
 
     }
}
