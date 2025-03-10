<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datos['products'] = Product::all();
        return view('product.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $taxes = Tax::all();
        return view('product.create', compact('taxes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $datosproduct = $request->validated();

        Product::create($datosproduct);

        return redirect('productos')->with('message', 'Producto Agregado');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::FindOrFail($id);
        $taxes = Tax::all();
        return view('product.edit', compact('product', 'taxes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $datosproduct = $request->validated();
        // Obtener el modelo
        $product = Product::findOrFail($id);

        // Actualizar los atributos del producto
        $product->fill($datosproduct); // Usar fill para actualizar el modelo

        // Convertir los campos a mayúsculas antes de guardar
        $product->setAttributesToUppercase(['internal_id', 'description', 'brand']);


        // Guardar el modelo
        $product->save();

        return redirect('productos')->with('message', 'Producto Actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
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
    $products = Product::where('description', 'like', '%' . $query . '%')
        ->orderBy('description', 'asc') // Opcional, ordena alfabéticamente
        ->with('tax')
        ->get();

    // Devolvemos los resultados como respuesta JSON
    return response()->json($products);

    }


  
}
