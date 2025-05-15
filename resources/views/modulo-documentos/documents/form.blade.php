 <!-- 2 column grid layout with text inputs for the first and last names -->
 @if ($errors->any())
     <div class="alert alert-danger" role="alert">
         <ul>
             @foreach ($errors->all() as $error)
                 <li>{{ $error }}</li>
             @endforeach
         </ul>
     </div>
 @endif




 <br>
<div class="row mb-4 col-md-12">
    <div class="col-md-2">
        <div data-mdb-input-init class="form-outline">
            <label class="form-label" for="code">&nbsp; CÓDIGO</label>
            <input type="text" id="code" name="code" value="{{ old('code', $document->code ?? '') }}"
                class="form-control" placeholder="ADM-001" />
        </div>
    </div>

    <div class="col-md-3">
        <div data-mdb-input-init class="form-outline">
            <label class="form-label" for="name">&nbsp;NOMBRE</label>
            <input type="text" id="name" name="name" value="{{ old('name', $document->name ?? '') }}"
                class="form-control" placeholder="REQUISICIÓN" />
        </div>
    </div>

    <div class="col-md-3">
        <div data-mdb-input-init class="form-outline">
            <label class="form-label" for="description">&nbsp;DESCRIPCIÓN</label>
            <input type="text" id="description" name="description" value="{{ old('description', $document->description ?? '') }}"
                class="form-control" placeholder="SOLICITAR MATERIAL" />
        </div>
    </div>

    <div class="col-md-2">
        <div data-mdb-input-init class="form-outline">
            <label class="form-label" for="version">&nbsp;VERSIÓN</label>
            <input type="text" id="version" name="version" value="{{ old('version', $document->version ?? '') }}"
                class="form-control" placeholder="V2.0" />
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-outline">
            <label class="form-label" for="category_id">&nbsp;CATEGORÍA</label>
            <select id="category_id" name="category_id" class="form-control">
                <option value="" {{ old('category_id', $document->category_id ?? '') == '' ? 'selected' : '' }}>Sin Categoría</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}"
                        {{ old('category_id', $document->category_id ?? '') == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>


 <div class="row mb-4 col-md-12">


     <div class="col-md-2">
         <div class="form-outline">
             <label class="form-label" for="download">&nbsp;¿DESCARGAR?</label>

             <select id="download" name="download" class="form-select">
                 <option value="0" {{ old('download', $document->download ?? 0) == 0 ? 'selected' : '' }}>NO
                 </option>
                 <option value="1" {{ old('download', $document->download ?? 0) == 1 ? 'selected' : '' }}>SI
                 </option>
             </select>

         </div>
     </div>

     <div class="col-md-2">
         <div class="form-outline">
             <label class="form-label" for="general">&nbsp;¿GENERAL?</label>

             <select id="general" name="general" class="form-select">
                 <option value="0" {{ old('general', $document->general ?? 0) == 0 ? 'selected' : '' }}>NO
                 </option>
                 <option value="1" {{ old('general', $document->general ?? 0) == 1 ? 'selected' : '' }}>SI
                 </option>
             </select>

         </div>
     </div>

     <div class="col-md-4">
         <div class="form-outline">
             <label class="form-label" for="file_pdf">&nbsp;ARCHIVO PDF</label>
             <input type="file" id="file_pdf" name="file_pdf" class="form-control" accept=".pdf">

             @error('file_pdf')
                 <small class="text-danger">{{ $message }}</small>
             @enderror
         </div>
     </div>

     <div class="col-md-4">
         <div class="form-outline">
             <label class="form-label" for="file_doc">&nbsp;ARCHIVO ORIGINAL</label>
             <input type="file" id="file_doc" name="file_doc" class="form-control" multiple>

             @error('file_pdf')
                 <small class="text-danger">{{ $message }}</small>
             @enderror
         </div>
     </div>


 </div>

 <div class="row mb-4 col-md-12">

     {{-- <div class="col-md-4">
         <div class="form-outline">
             <label class="form-label" for="revisor_id">&nbsp;Sin revisor</label>

             <select id="revisor_id" name="revisor_id" class="form-control">
                 <option value=""
                     {{ old('revisor_id', $user->revisor_id ?? '') == '' ? 'selected' : '' }}>Sin revisor</option>
                 @foreach ($users as $revisor)
                     <option value="{{ $revisor->id }}"
                         {{ old('revisor_id', $revisor->revisor_id ?? '') == $revisor->id ? 'selected' : '' }}>
                         {{ $revisor->name }}
                     </option>
                 @endforeach
             </select>
         </div>
     </div> --}}


   

     <div class="col-md-2">
         <div class="form-outline">
             <label class="form-label" for="area_resp_id">&nbsp;DEP. RESPONSABLE</label>

             <select id="area_resp_id" name="area_resp_id" class="form-control">
                 <option value="" {{ old('area_resp_id', $user->area_resp_id ?? '') == '' ? 'selected' : '' }}>
                     Sin
                     Area asignada</option>
                 @foreach ($areas as $area)
                     <option value="{{ $area->id }}"
                         {{ old('area_resp_id', $revisor->area_resp_id ?? '') == $area->id ? 'selected' : '' }}>
                         {{ $area->name }}
                     </option>
                 @endforeach
             </select>
         </div>
     </div>

<div class="col-md-2">
         <label for="areas" class="form-label">Áreas destinadas</label>
         <select name="areas[]" id="areas" multiple class="form-select" data-placeholder="Selecciona las áreas">
             @foreach ($areas as $area)
                 <option value="{{ $area->id }}">{{ $area->name }}</option>
             @endforeach
         </select>
     </div>



     <div class="col-md-2">
         <label class="form-label" for="contract">¿ACTIVO?</label>

         <div class="form-outline">
             <select id="active" name="active" class="form-select">
                 <option value="1"
                     {{ old('active', isset($document) ? $document->active : 1) == 1 ? 'selected' : '' }}>SI</option>
                 <option value="0"
                     {{ old('active', isset($document) ? $document->active : 1) == 0 ? 'selected' : '' }}>NO</option>
             </select>
         </div>
     </div>

 </div>


 <div class="row mb-4 col-md-12">
    
     <div class="col-md-3">
         <div class="form-outline">
             <label class="form-label" for="revisor_id">&nbsp;REVISOR</label>

             <select id="revisor_id" name="revisor_id" class="form-control">
                 <option value="" {{ old('revisor_id', $user->revisor_id ?? '') == '' ? 'selected' : '' }}>Sin
                     revisor</option>
                 @foreach ($users as $revisor)
                     <option value="{{ $revisor->id }}"
                         {{ old('revisor_id', $revisor->revisor_id ?? '') == $revisor->id ? 'selected' : '' }}>
                         {{ $revisor->name }}
                     </option>
                 @endforeach
             </select>
         </div>
     </div>

     <div class="col-md-3">
         <label class="form-label">STATUS REVISOR</label>
         <div class="form-outline">
             <select class="form-select" name="auth_1" id="auth_1">
                 <option value="PENDIENTE"
                     {{ old('auth_1', isset($document) && $document->auth_1 == 'PENDIENTE' ? 'selected' : '') }}>PENDIENTE
                 </option>
                 <option value="AUTORIZADO"
                     {{ old('auth_1', isset($document) && $document->auth_1 == 'AUTORIZADO' ? 'selected' : '') }}>
                     AUTORIZADO</option>
                 <option value="RECHAZADO"
                     {{ old('auth_1', isset($document) && $document->auth_1 == 'RECHAZADO' ? 'selected' : '') }}>RECHAZADO
                 </option>
             </select>
         </div>
     </div>

       <div class="col-md-3">
         <div class="form-outline">
             <label class="form-label" for="aprobador_id">&nbsp;APROBADOR</label>

             <select id="aprobador_id" name="aprobador_id" class="form-control">
                 <option value="" {{ old('aprobador_id', $aprobador->id ?? '') == '' ? 'selected' : '' }}>
                     Sin aprobador</option>
                 @foreach ($users as $aprobador)
                     <option value="{{ $aprobador->id }}"
                         {{ old('aprobador_id', $aprobador->aprobador_id ?? '') == $aprobador->id ? 'selected' : '' }}>
                         {{ $aprobador->name }}
                     </option>
                 @endforeach
             </select>
         </div>
     </div>

       <div class="col-md-3">
         <label class="form-label">STATUS APROBADOR</label>
         <div class="form-outline">
             <select class="form-select" name="auth_2" id="auth_2">
                 <option value="PENDIENTE"
                     {{ old('auth_2', isset($document) && $document->auth_2 == 'PENDIENTE' ? 'selected' : '') }}>PENDIENTE
                 </option>
                 <option value="AUTORIZADO"
                     {{ old('auth_2', isset($document) && $document->auth_2 == 'AUTORIZADO' ? 'selected' : '') }}>
                     AUTORIZADO</option>
                 <option value="RECHAZADO"
                     {{ old('auth_2', isset($document) && $document->auth_2 == 'RECHAZADO' ? 'selected' : '') }}>RECHAZADO
                 </option>
             </select>
         </div>
     </div>



 </div>
 <!-- Submit button -->
 <button type="submit" class="btn btn-primary btn-block mb-4 m-2">{{ $modo }} Documento</button>

 <button type="button" class="btn btn-warning btn-block mb-3"> <a class="text-white"
         href="{{ url('users-sgi/') }}">
         Regresar
     </a> </button>

 @push('js')
     <!-- Styles -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
     <link rel="stylesheet"
         href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

     <!-- Scripts -->
     <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

     <script>
         $(document).ready(function() {
             $('#multiple-select-field, #areas').select2({
                 theme: 'bootstrap-5',
                 width: '100%',
                 placeholder: function() {
                     return $(this).data('placeholder') || 'Selecciona una opción';
                 },
                 closeOnSelect: false
             });
         });
     </script>
 @endpush
