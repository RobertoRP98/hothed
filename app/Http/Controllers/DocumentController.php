<?php

namespace App\Http\Controllers;

use App\Models\AreaSgi;
use App\Models\UserSgi;
use App\Models\Document;
use App\Models\DocumentsCategories;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = Document::with(['category', 'revisor', 'aprobador', 'areaResponsable'])->latest()->get();

        return view('modulo-documentos.documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $areas = AreaSgi::all();
        $categorias = DocumentsCategories::all();
        $users = UserSgi::all();

        return view('modulo-documentos.documents.create', compact('areas', 'categorias', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocumentRequest $request)
    {

       // dd($request->allFiles());

        if ($request->hasFile('file_pdf')) {
            Log::info('PDF recibido: ' . $request->file('file_pdf')->getClientOriginalName());
        }

        if ($request->hasFile('file_doc')) {
            Log::info('DOC recibido: ' . $request->file('file_doc')->getClientOriginalName());
        }

        $originalNamePdf = $request->file('file_pdf')?->getClientOriginalName();
        $originalNameDoc = $request->file('file_doc')?->getClientOriginalName();
        // Asegura nombres únicos
        $filenamePdf = $originalNamePdf ? uniqid() . '-' . $originalNamePdf : null;
        $filenameDoc = $originalNameDoc ? uniqid() . '-' . $originalNameDoc : null;

        $filePathPdf = $filenamePdf ? $request->file('file_pdf')->storeAs('pdfs-sgi', $filenamePdf) : null;
        $filePathDoc = $filenameDoc ? $request->file('file_doc')->storeAs('documentos-sgi', $filenameDoc) : null;



        Log::info('Ruta PDF guardada: ' . $filePathPdf);
        Log::info('Ruta DOC guardada: ' . $filePathDoc);



        //Crear documento
        $document = Document::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'version' => $request->version,
            'category_id' => $request->category_id,
            'download' => $request->boolean('download'),
            'general' => $request->boolean('general'),
            'file_path_pdf' => $filePathPdf,
            'file_path_doc' => $filePathDoc,
            'revisor_id' => $request->revisor_id,
            'aprobador_id' => $request->aprobador_id,
            'area_resp_id' => $request->area_resp_id,
            'auth_1' => $request->auth_1,
            'auth_2' => $request->auth_2,
            'active' => $request->active,
        ]);

        $document->areas()->sync($request->areas);

        return redirect()->route('documentacion-sgi.index')->with('success', 'Documento creado correctamente');
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

    public function download($type, $id)
    {
        $document = Document::findOrFail($id);

        if ($type === 'pdf' && $document->file_path_pdf) {
            return Storage::download($document->file_path_pdf);
        }

        if ($type === 'doc' && $document->file_path_doc) {
            return Storage::download($document->file_path_doc);
        }

        return abort(404, 'Archivo no disponible');
    }
}
