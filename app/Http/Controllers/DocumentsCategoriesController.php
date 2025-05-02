<?php

namespace App\Http\Controllers;

use App\Models\DocumentsCategories;
use App\Http\Requests\StoreDocuments_CategoriesRequest;
use App\Http\Requests\UpdateDocuments_CategoriesRequest;

class DocumentsCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = DocumentsCategories::paginate(30);

        return view ('categories-sgi.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories-sgi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocuments_CategoriesRequest $request)
    {
        $datoscategory = $request->validated();

        DocumentsCategories::create($datoscategory);

        return redirect('categorias-documentos')->with('message','Categoria para Documentos Creada');
    }

    /**
     * Display the specified resource.
     */
    public function show(DocumentsCategories $documents_Categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = DocumentsCategories::FindOrFail($id);

        return view('categories-sgi.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocuments_CategoriesRequest $request, $id)
    {
        $datoscategory = $request->validated();

        DocumentsCategories::where('id',$id)->update($datoscategory);

        return redirect('categorias-documentos')->with('message','Categoria para Documentos Actualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocumentsCategories $documents_Categories)
    {
        //
    }
}
