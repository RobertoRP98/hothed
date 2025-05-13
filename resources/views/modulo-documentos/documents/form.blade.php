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
             <label class="form-label" for="code">&nbsp; CODIGO</label>
             <input type="text" id="code" name="code" value="{{ isset($document) ? $document->code : '' }}"
                 class="form-control " placeholder="ADM-001" />
         </div>
     </div>

     <div class="col-md-3">
         <div data-mdb-input-init class="form-outline">
             <label class="form-label" for="name">&nbsp;NOMBRE</label>
             <input type="text" id="name" name="name" value="{{ isset($document) ? $document->name : '' }}"
                 class="form-control " placeholder="REQUISICIÓN" />
         </div>
     </div>

     <div class="col-md-3">
         <div data-mdb-input-init class="form-outline">
             <label class="form-label" for="description">&nbsp;DESCRIPCIÓN</label>
             <input type="text" id="description" name="description"
                 value="{{ isset($document) ? $document->description : '' }}" class="form-control "
                 placeholder="SOLICITAR MATERIAL" />
         </div>
     </div>



     <div class="col-md-2">
         <div data-mdb-input-init class="form-outline">
             <label class="form-label" for="version">&nbsp;VERSIÓN</label>
             <input type="text" id="version" name="version"
                 value="{{ isset($document) ? $document->version : '' }}" class="form-control " placeholder="V2.0" />
         </div>
     </div>


     <div class="col-md-2">
         <div class="form-outline">
             <label class="form-label" for="workstation_id">&nbsp;PUESTO DE TRABAJO</label>

             <select id="category_id" name="category_id" class="form-control">
                 <option value="" {{ old('category_id', $document->category_id ?? '') == '' ? 'selected' : '' }}>
                     Sin Categoria</option>
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
             <label class="form-label" for="contract">&nbsp;¿DESCARGAR?</label>

             <select id="download" name="download" class="form-select">
                 <option value="0" {{ old('download', $document->download ?? 0) == 0 ? 'selected' : '' }}>NO
                 </option>
                 <option value="1" {{ old('download', $document->download ?? 0) == 1 ? 'selected' : '' }}>SI
                 </option>
             </select>

         </div>
     </div>

     {{-- <div class="col-md-3">
    <div class="form-outline">
        <select id="area_id" name="area_id" class="form-control">
            <option value="" {{ old('area_id', $user->area_id ?? '') == '' ? 'selected' : '' }}>Sin Área de Trabajo</option>
            @foreach ($areas as $area)
                <option value="{{ $area->id }}" 
                    {{ old('area_id', $user->area_id ?? '') == $area->id ? 'selected' : '' }}>
                    {{ $area->name }}
                </option>
            @endforeach
        </select>
        <label class="form-label" for="workstation_id">Area de Trabajo</label>
    </div>
  </div> --}}
     {{-- 
  <div class="col-md-3">
    <div class="form-outline">
        <select id="workstation_id" name="workstation_id" class="form-control">
            <option value="" {{ old('workstation_id', $user->workstation_id ?? '') == '' ? 'selected' : '' }}>Sin Puesto de Trabajo</option>
            @foreach ($workstations as $workstation)
                <option value="{{ $workstation->id }}" 
                    {{ old('workstation_id', $user->workstation_id ?? '') == $workstation->id ? 'selected' : '' }}>
                    {{ $workstation->name }}
                </option>
            @endforeach
        </select>
        <label class="form-label" for="workstation_id">Puesto de trabajo</label>
    </div>
</div> --}}

     {{-- <div class="col-md-4">
    <div class="form-outline">
        <select id="immediate_boss_id" name="immediate_boss_id" class="form-control">
            <option value="" {{ old('immediate_boss_id', $user->immediate_boss_id ?? '') == '' ? 'selected' : '' }}>Sin Jefe Inmediato</option>
            @foreach ($users as $boss)
                <option value="{{ $boss->id }}" 
                    {{ old('immediate_boss_id', $user->immediate_boss_id ?? '') == $boss->id ? 'selected' : '' }}>
                    {{ $boss->name }}
                </option>
            @endforeach
        </select>
        <label class="form-label" for="immediate_boss_id">Jefe Inmediato</label>
    </div>
</div> --}}


     {{-- <div class="col-md-2">
    <div class="form-outline">
        <select id="active" name="active" class="form-select">
            <option value="1" {{ old('active', isset($user) ? $user->active : 1) == 1 ? 'selected' : '' }}>SI</option>
            <option value="0" {{ old('active', isset($user) ? $user->active : 1) == 0 ? 'selected' : '' }}>NO</option>
        </select>
        <label class="form-label" for="contract">¿EMPLEADO ACTIVO?</label>
    </div>
    </div> --}}

 </div>


 <!-- Submit button -->
 <button type="submit" class="btn btn-primary btn-block mb-4 m-2">{{ $modo }} Usuario</button>

 <button type="button" class="btn btn-warning btn-block mb-3"> <a class="text-white" href="{{ url('users-sgi/') }}">
         Regresar
     </a> </button>
