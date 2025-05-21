<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentsTypesRequest;
use App\Http\Requests\UpdateDocumentsTypesRequest;
use App\Models\DocumentsTypes;
use Illuminate\Support\Facades\Log;

class DocumentsTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
          $types = DocumentsTypes::paginate(30);

        return view ('modulo-documentos.types-sgi.index',compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('modulo-documentos.types-sgi.create');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocumentsTypesRequest $request)
    {
        $datostype = $request->validated();

        DocumentsTypes::create($datostype);


        return redirect('tipos-documentos')->with('message','Tipo para Documentos Creado');
    }

    /**
     * Display the specified resource.
     */
    public function show(DocumentsTypes $documentsTypes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $type = DocumentsTypes::FindOrFail($id);

        return view('modulo-documentos.types-sgi.edit',compact('type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocumentsTypesRequest $request, $id)
    {
        $datostype = $request->validated();

        DocumentsTypes::where('id',$id)->update($datostype);

        return redirect('tipos-documentos')->with('message','Tipo para Documentos Actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocumentsTypes $documentsTypes)
    {
        //
    }
}
