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


  <div class="col-md-4">
    <div class="form-outline">
        <select class="form-select" name="status_requisition" id="status_requisition" disabled>
        <option value="Pendiente" {{old('status_requisition',isset($requisition) && $requisition->status_requisition == 'Pendiente' ? 'selected':'')}}>PENDIENTE</option>
        <option value="Autorizado" {{old('status_requisition',isset($requisition) && $requisition->status_requisition == 'Autorizado' ? 'selected':'')}}>AUTORIZADO</option>
        <option value="Rechazado" {{old('status_requisition',isset($requisition) && $requisition->status_requisition == 'Rechazado' ? 'selected':'')}}>RECHAZADO</option>
        </select>
        <label class="form-label">STATUS DE LA REQUISICIÓN</label>
  </div>   
  </div>

  <div class="col-md-4">
    <div class="form-outline">
        <select class="form-select" name="importance" id="importance">
        <option value="Baja" {{old('category',isset($requisition) && $requisition->importance == 'Baja' ? 'selected':'')}}>BAJA</option>
        <option value="Media" {{old('category',isset($requisition) && $requisition->importance == 'Media' ? 'selected':'')}}>MEDIA</option>
        <option value="Alta" {{old('category',isset($requisition) && $requisition->importance == 'Alta' ? 'selected':'')}}>ALTA</option>
        </select>
        <label class="form-label">IMPORTANCIA DE LA REQUISICIÓN</label>
  </div>   
  </div>

  <div class="col-md-3">
    <div class="form-outline">
        <select id="finished" name="finished" class="form-select" disabled>
            <option value="0" {{ old('finished', isset($requisition) ? $requisition->unique : 0) == 0 ? 'selected' : '' }}>NO</option>
            <option value="1" {{ old('finished', isset($requisition) ? $requisition->unique : 0) == 1 ? 'selected' : '' }}>SI</option>
        </select>
        <label class="form-label" for="unique">¿REQUISICIÓN FINALIZADA?</label>
    </div>
  </div>

</div>

<!-- Segunda fila -->
<div class="row mb-4">  

  <div class="col-md-6">
    <div class="form-outline">
        <input type="date" id="request_date" name="request_date" value="{{isset($requisition) ? $requisition->request_date : ''}}" class="form-control" readonly/>
        <label class="form-label" for="request_date">FECHA DE SOLICITUD</label>
    </div>
</div>

<div class="col-md-6">
  <div class="form-outline">
      <input type="date" id="production_date" name="production_date" value="{{isset($requisition) ? $requisition->production_date : ''}}" class="form-control" readonly/>
      <label class="form-label" for="production_date">FECHA DE RESPUESTA</label>
  </div>
</div>


</div>

<!-- Tercera fila -->
<div class="row mb-4">
  <div id="app">
    <compras-component>

    </compras-component>
</div>
</div>

<br>
 <!-- Submit button -->
 <div class="row mb-4 col-md-6">

 <button type="submit" class="btn btn-primary btn-block col-md-3 m-1">{{$modo}} Requisición</button>
 
 <button type="button" class="btn btn-warning btn-block col-md-3 m-1"> <a class="text-white" href="{{ url('requisiciones/') }}">
    Regresar
</a> </button> 

 </div>