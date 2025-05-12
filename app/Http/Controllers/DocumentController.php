<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Models\Document;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = Document::with(['category','revisor','aprobador','areaResponsable'])->latest()->get();

        return view('documents.index',compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('documents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocumentRequest $request)
    {
        $filePath = $request->file('file')->store('documentos-sgi');

        //Crear documento
        $document = Document::create([
            'code'=> $request->code,
            'name'=> $request->name,
            'description'=> $request->description,
            'version'=> $request->version,
            'category_id'=> $request->category_id,
            'download'=> $request->boolean('download'),
            'general'=> $request->boolean('general'),
            'file_path'=> $filePath,
            'revisor_id'=> $request->revisor_id,
            'aprobador_id'=> $request->aprobador_id,
            'area_resp_id'=> $request->area_resp_id,
            'auth_1'=> $request->auth_1,
            'auth_2'=> $request->auth_2,
            'active'=> $request->active,
        ]);

        return redirect()->route('documents.index')->with('success','Documento creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocumentRequest $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        //
    }
}
