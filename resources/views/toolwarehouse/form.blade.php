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
  <!-- Primera fila -->
  <div class="row mb-4">
    <div class="col-md-3">
        <div class="form-outline">
            <select id="family_id" name="family_id" class="form-control">
                <option value="" disabled {{ !isset($toolwarehouse) ? 'selected' : '' }}>Selecciona una Familia</option>
                @foreach($families as $family)
                    <option value="{{ $family->id }}" 
                        {{ (isset($toolwarehouse) && $toolwarehouse->family_id == $family->id) || old('family_id') == $family->id ? 'selected' : '' }}>
                        {{ $family->name }}
                    </option>
                @endforeach
            </select>
            <label class="form-label" for="family_id">Familia</label>
        </div>
    </div>


      <div class="col-md-3">
         <div class="form-outline">
            <select name="subgroup_id" id="subgroup_id" class="form-control">
                <option value="" disabled {{ !isset($toolwarehouse) ? 'selected':''}}>Selecciona un Subgrupo</option>
                @foreach($subgroups as $sub)
                <option value="{{$sub->id}}"
                  {{(isset($toolwarehouse)&& $toolwarehouse->subgroups_id==$sub->id)|| old('subgroup_id')==$sub->id ? 'selected' : ''}}>
                  {{$sub->name}}
                </option>
                @endforeach
            </select>
            <label class="form-label" for="subgroup_id">Subgrupo</label>
         </div>
      </div>

      <div class="col-md-3">
          <div class="form-outline">
              <input type="text" id="description" name="description" value="{{isset($toolwarehouse) ? $toolwarehouse->description : ''}}" class="form-control" />
              <label class="form-label" for="description">Descripción</label>
          </div>
      </div>

      <div class="col-md-3">
        <div class="form-outline">
            <input type="text" id="serienum" name="serienum" value="{{isset($toolwarehouse) ? $toolwarehouse->serienum: ''}}" class="form-control" />
            <label class="form-label" for="serienum">Numero de serie</label>
        </div>
    </div>

  </div>

  <!-- Segunda fila -->
  <div class="row mb-4">
      
      <div class="col-md-3">
        <div class="form-outline">
           <select name="base_id" id="base_id" class="form-control">
            <option value="" disabled {{!isset($toolwarehouse) ? 'selected' :''}}>Base de operaciones</option>
            @foreach($bases as $base)
            <option value="{{$base->id}}"
                {{(isset($toolwarehouse) && $toolwarehouse->bases_id==$base->id) || old('base_id')==$base->id ? 'selected':''}}>
                {{$base->name}}
            </option>
            @endforeach
           </select>
           <label class="form-label"  for="base_id">Base Operativa</label>
        </div>
    </div>

    <div class="col-md-3">
      <div class="form-outline">
          <select name="toolstatus_id" id="toolstatus_id" class="form-control">
            <option value="" disabled {{!isset($toolwarehouse) ? 'selected' : ''}}>Status de Herramienta</option>
            @foreach($toolstatus as $tool)
            <option value="{{$tool->id}}"
            {{(isset($toolwarehouse) && $toolwarehouse->toolstatus_id==$tool->id)|| old('toolstatus_id')==$tool->id ? 'selected':''}}>
            {{$tool->status}}
            </option>
            @endforeach
          </select>
          <label class="form-label" for="toolstatus_id">Status de Herramienta </label> 
      </div>
  </div>

      <div class="col-md-3">
          <div class="form-outline">
              <input type="text" id="extdia" name="extdia" value="{{isset($toolwarehouse) ? $toolwarehouse->extdia : ''}}" class="form-control" />
              <label class="form-label" for="extdia">Diametro exterior</label>
          </div>
      </div>

      <div class="col-md-3">
        <div class="form-outline">
            <input type="text" id="insdia" name="insdia" value="{{isset($toolwarehouse) ? $toolwarehouse->insdia : ''}}" class="form-control" />
            <label class="form-label" for="insdia">Diametro interior</label>
        </div>
    </div>
  </div>

  <!-- Tercera fila -->
  <div class="row mb-4">
      
      <div class="col-md-3">
          <div class="form-outline">
              <input type="text" id="fishingneck" name="fishingneck" value="{{isset($toolwarehouse) ? $toolwarehouse->fishingneck : ''}}" class="form-control" />
              <label class="form-label" for="fishingneck">Cuello de pesco</label>
          </div>
      </div>

      <div class="col-md-3">
          <div class="form-outline">
              <input type="text" id="conpin" name="conpin" value="{{isset($toolwarehouse) ? $toolwarehouse->conpin : ''}}" class="form-control" />
              <label class="form-label" for="conpin">Pin de conexión</label>
          </div>
      </div>

    <div class="col-md-3">
      <div class="form-outline">
          <input type="text" id="guidia" name="guidia" value="{{isset($toolwarehouse) ? $toolwarehouse->guidia : ''}}" class="form-control" />
          <label class="form-label" for="guidia">Diametro de guia</label>
      </div>
  </div>

  <!-- Cuarta fila -->
  
  <div class="row mb-4">
      <div class="col-md-3">
          <div class="form-outline">
              <input type="text" id="conbox" name="conbox" value="{{isset($toolwarehouse) ? $toolwarehouse->conbox : ''}}" class="form-control" />
              <label class="form-label" for="conbox">Conexión Box</label>
          </div>
      </div>

      <div class="col-md-3">
          <div class="form-outline">
              <input type="text" id="opera" name="opera" value="{{isset($toolwarehouse) ? $toolwarehouse->opera : ''}}" class="form-control" />
              <label class="form-label" for="opera">Rango de operación</label>
          </div>
      </div>

      <div class="col-md-3">
          <div class="form-outline">
              <input type="text" id="length" name="length" value="{{isset($toolwarehouse) ? $toolwarehouse->length : ''}}" class="form-control" />
              <label class="form-label" for="length">Longitud</label>
          </div>
      </div>
  </div>

  <!-- Quinta fila -->
  <div class="row mb-4">
      <div class="col-md-4">
          <div class="form-outline">
              <input type="text" id="necklength" name="necklength" value="{{isset($toolwarehouse) ? $toolwarehouse->necklength : ''}}" class="form-control" />
              <label class="form-label" for="necklength">Longitud de cuello</label>
          </div>
      </div>

      <div class="col-md-4">
          <div class="form-outline">
              <input type="text" id="lastinsp" name="lastinsp" value="{{isset($toolwarehouse) ? $toolwarehouse->lastinsp : ''}}" class="form-control" />
              <label class="form-label" for="lastinsp">Folio ultima inspección</label>
          </div>
      </div>

      <div class="col-md-4">
          <div class="form-outline">
              <input type="date" id="datelastinsp" name="datelastinsp" value="{{isset($toolwarehouse) ? $toolwarehouse->datelastinsp : ''}}" class="form-control" />
              <label class="form-label" for="datelastinsp">Fecha de ultima inspección</label>
          </div>
      </div>
  </div>

  <!-- Sexta fila -->
  <div class="row mb-4">
      <div class="col-md-4">
          <div class="form-outline">
              <input type="text" id="outfolio" name="outfolio" value="{{isset($toolwarehouse) ? $toolwarehouse->outfolio : ''}}" class="form-control" />
              <label class="form-label" for="outfolio">Folio de salida</label>
          </div>
      </div>

      <div class="col-md-4">
          <div class="form-outline">
              <input type="date" id="departuredate" name="departuredate" value="{{isset($toolwarehouse) ? $toolwarehouse->departuredate : ''}}" class="form-control" />
              <label class="form-label" for="departuredate">Fecha de salida</label>
          </div>
      </div>

     
  </div>

  <!-- Séptima fila -->
  <div class="row mb-4">
      <div class="col-md-4">
          <div class="form-outline">
              <input type="text" id="comentary" name="comentary" value="{{isset($toolwarehouse) ? $toolwarehouse->comentary : ''}}" class="form-control" />
              <label class="form-label" for="comentary">Comentario</label>
          </div>
      </div>

      <div class="col-md-4">
          <div class="form-outline">
              <input type="text" id="intloca" name="intloca" value="{{isset($toolwarehouse) ? $toolwarehouse->intloca : ''}}" class="form-control" />
              <label class="form-label" for="intloca">Localización interna</label>
          </div>
      </div>

      <div class="col-md-4">
          <div class="form-outline">
              <input type="text" id="QR" name="QR" value="{{isset($toolwarehouse) ? $toolwarehouse->QR : ''}}" class="form-control" />
              <label class="form-label" for="QR">QR</label>
          </div>
      </div>
  </div>

   <!-- Submit button -->
   <div class="col-md-4">
 <button type="submit" class="btn btn-primary btn-block mb-4">{{$modo}} Herramienta</button>

 <button type="button" class="btn btn-warning btn-block mb-4"> <a class="text-white" href="{{ url('almacenherramientas/') }}">
    Regresar
</a> </button> 
</div>
