<?php

namespace App\Http\Controllers;

use App\Models\AreaSgi;
use App\Models\UserSgi;
use App\Models\Document;
use App\Models\DocumentsTypes;
use App\Models\DocumentsCategories;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = Document::with(['category', 'revisor', 'aprobador', 'areaResponsable'])->latest()->get()
            ->map(function ($doc) {
                //SI EL ARCHIVO TERMINA EN .pdf se anula el boton en el front
                if ($doc->file_path_doc && strtolower(pathinfo($doc->file_path_doc, PATHINFO_EXTENSION)) === 'pdf') {
                    $doc->file_path_doc = null;
                }
                return $doc;
            });

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
        $types = DocumentsTypes::all();

        return view('modulo-documentos.documents.create', compact('areas', 'categorias', 'users', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(StoreDocumentRequest $request)
    {
        if ($request->hasFile('file_doc')) {
            Log::info('DOC recibido: ' . $request->file('file_doc')->getClientOriginalName());

            $originalNameDoc = $request->file('file_doc')->getClientOriginalName();
            $extension = strtolower($request->file('file_doc')->getClientOriginalExtension());
            $filenameDoc = $originalNameDoc; //DEJALO ASI AQUI ANTES HABIA ALGO MAS PARA ID UNIQUE uniqid()
            $filePathDoc = $request->file('file_doc')->storeAs('documentos-sgi', $filenameDoc);

            Log::info('Ruta DOC guardada: ' . $filePathDoc);

            // Solo convertir si NO es PDF
            if ($extension !== 'pdf') {
                $filePathPdf = $this->convertirADocumentoPDF($filePathDoc); //AQUI ENTRA LA FUNCION
            } else {
                // Si ya es PDF, lo dejamos como está
                $filePathPdf = $filePathDoc;
            }
        }

        // Crear documento
        $document = Document::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'version' => $request->version,
            'category_id' => $request->category_id,
            'file_path_doc' => $filePathDoc ?? null,
            'file_path_pdf' => $filePathPdf ?? null,
            'revisor_id' => $request->revisor_id,
            'aprobador_id' => $request->aprobador_id,
            'area_resp_id' => $request->area_resp_id,
            'auth_1' => 'PENDIENTE',
            'auth_2' => 'PENDIENTE',
            'active' => $request->active,
            'type_id' => $request->type_id,
        ]);

        $document->areas()->sync($request->areas);

        return redirect()->route('documentacion-sgi.index')->with('success', 'Documento creado correctamente');
    }

    public function convertirADocumentoPDF(string $documentPath): ?string
    {
        $fullPath = storage_path('app/' . $documentPath);
        $outputDir = storage_path('app/pdfs-sgi');

        // Asegura que el directorio destino exista
        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0755, true);
        }

        $process = new Process([
            'libreoffice',
            '--headless',
            '-env:UserInstallation=file://' . storage_path('app/temp-libreoffice'),
            '--convert-to',
            'pdf',
            '--outdir',
            $outputDir,
            $fullPath,
        ]);


        $process->run();

        if (!$process->isSuccessful()) {
            logger()->error('Error al convertir documento a PDF: ' . $process->getErrorOutput());
            return null;
        }

        $filename = pathinfo($documentPath, PATHINFO_FILENAME) . '.pdf';
        return 'pdfs-sgi/' . $filename;
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
    public function edit($id)
    {
        $document = Document::with('areas')->findOrFail($id);

        $areas = AreaSgi::all();
        $categorias = DocumentsCategories::all();
        $users = UserSgi::all();
        $types = DocumentsTypes::all();

        return view('modulo-documentos.documents.edit', compact('areas', 'categorias', 'users', 'types', 'document'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocumentRequest $request, Document $document)
    {
        $filePathDoc = $document->file_path_doc;
        $filePathPdf = $document->file_path_pdf;


        //AQUI INSPECCIONAMOS QUE SI ES UN NUEVO ARCHIVO SE HAGA EL PROCESO DE GUARDADO Y CONVERSION
        if ($request->hasFile('file_doc')) {
            $newOriginalName = $request->file('file_doc')->getClientOriginalName();

            //SOLO SI SUBEN UN NUEVO ARCHIVO SE PROCESA
            if ($newOriginalName !== basename($document->file_path_doc)) {
                Log::info('Nuevo DOC recibido:' . $newOriginalName);

                $extension = strtolower($request->file('file_doc')->getClientOriginalExtension());
                $filenameDoc = $newOriginalName;
                $filePathDoc = $request->file('file_doc')->storeAs('documentos-sgi', $filenameDoc);

                Log::info('Ruta DOC guardada: ' . $filePathDoc);

                //Convertir solo si no es PDF

                if ($extension !== 'pdf') {
                    $filePathPdf = $this->convertirADocumentoPDF($filePathDoc);
                } else {
                    $filePathPdf = $filePathDoc;
                }
            } else {
                Log::info('EL ARCHIVO SUBIDO ES EL MISMO, NO SE ACTUALIZA NI SE CONVIERTE');
            }
        }

        //Actualizar los demas campos

        $document->update([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'version' => $request->version,
            'category_id' => $request->category_id,
            'file_path_doc' => $filePathDoc,
            'file_path_pdf' => $filePathPdf,
            'revisor_id' => $request->revisor_id,
            'aprobador_id' => $request->aprobador_id,
            'area_resp_id' => $request->area_resp_id,
            'auth_1' => $request->auth_1,
            'auth_2' => $request->auth_2,
            'active' => $request->active,
            'type_id' => $request->type_id,
        ]);

        $document->areas()->sync($request->areas);

        return redirect()->route('documentacion-sgi.index')->with('success', 'Documento actualizado correctamente');
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

    public function streampdf($id)
    {
        $document = Document::findOrFail($id);

        $path = $document->file_path_pdf; // ya viene con "pdfs-sgi/ejemplo.pdf"
        $filename = basename($path);

        if (!Storage::disk('local')->exists($path)) {
            abort(404, 'PDF no encontrado');
        }

        return new StreamedResponse(function () use ($path) {
            $stream = Storage::disk('local')->readStream($path);
            fpassthru($stream);
        }, 200, [
            "Content-Type" => "application/pdf",
            "Content-Disposition" => "inline; filename=\"{$filename}\""
        ]);
    }

    public function indexgeneral(){

        $documents = Document::with('areas')
        ->whereHas('areas',function($query){
            $query->where('areas_sgi.id',1);
        })
        ->get();

        return view('modulo-documentos.documents.generales',compact('documents'));
    }

    public function documentosPorArea(){

        //CATH DEL USUARIO LOGUEADO
        $correo = Auth::user()->email;

        //BUSCAR ESE USUARIO EN USERS_SGI
        $usuarioSGI  = UserSgi::where('email',$correo)->first();

        if(!$usuarioSGI){
                abort(403, 'USUARIO NO AUTORIZADO');
        }
        //AQUI SE RESCATA EL AREA QUE TRAE EL USUARIO PERO A NIVEL TABLA USERS_SGI
        $areaId = $usuarioSGI->area_id;

        //BUSCAR DOCUMENTOS REALACIONADOS A ESA AREA RESCATADA

        $documents = Document::with('areas')
        ->whereHas('areas', function($query) use ($areaId){
            $query->where('areas_sgi.id',$areaId);
        })
        ->get();


        return view('modulo-documentos.documents.myarea',compact('documents'));
    }

    public function documentosPorRevisar(){

        //CATH DEL USUARIO LOGUEADO
        $correo = Auth::user()->email;

        //BUSCAR ESE USUARIO EN USERS_SGI
        $usuarioSGI  = UserSgi::where('email',$correo)->first();

        if(!$usuarioSGI){
                abort(403, 'USUARIO NO AUTORIZADO');
        }
        //AQUI SE RESCATA EL AREA QUE TRAE EL USUARIO PERO A NIVEL TABLA USERS_SGI
        $areaId = $usuarioSGI->id;

        //BUSCAR DOCUMENTOS REALACIONADOS A ESA AREA RESCATADA

        $documents = Document::with('areas')
        ->where('revisor_id', $usuarioSGI->id)
        ->where('auth_1','PENDIENTE')
        ->get();

        return view('modulo-documentos.documents.user.revisiones-user',compact('documents'));
    }

       public function documentosPorAprobar(){

        //CATH DEL USUARIO LOGUEADO
        $correo = Auth::user()->email;

        //BUSCAR ESE USUARIO EN USERS_SGI
        $usuarioSGI  = UserSgi::where('email',$correo)->first();

        if(!$usuarioSGI){
                abort(403, 'USUARIO NO AUTORIZADO');
        }
        //AQUI SE RESCATA EL AREA QUE TRAE EL USUARIO PERO A NIVEL TABLA USERS_SGI
        $areaId = $usuarioSGI->id;

        //BUSCAR DOCUMENTOS REALACIONADOS A ESA AREA RESCATADA

        $documents = Document::with('areas')
        ->where('aprobador_id', $usuarioSGI->id)
        ->where('auth_2','PENDIENTE')
        ->get();

        return view('modulo-documentos.documents.user.aprobaciones-user',compact('documents'));
    }


    public function editRevision($id)
    {
        $document = Document::with('areas')->findOrFail($id);

        $areas = AreaSgi::all();
        $categorias = DocumentsCategories::all();
        $users = UserSgi::all();
        $types = DocumentsTypes::all();

        return view('modulo-documentos.documents.user.edit-revision', compact('areas', 'categorias', 'users', 'types', 'document'));
    }

    
}
