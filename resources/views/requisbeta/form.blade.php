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
        <select class="form-select" name="dep_soli" id="dep_soli">
        <option value="ADMINISTRACION" {{old('dep_soli',isset($requi) && $requi->dep_soli == 'ADMINISTRACION' ? 'selected':'')}}>ADMINISTRACION</option>
        <option value="OPERACIONES" {{old('dep_soli',isset($requi) && $requi->dep_soli == 'OPERACIONES' ? 'selected':'')}}>OPERACIONES</option>
        <option value="SGI" {{old('dep_soli',isset($requi) && $requi->dep_soli == 'BAJA' ? 'SGI':'')}}>SGI</option>
        </select>
        <label class="form-label">DEPARTAMENTO SOLICITANTE</label>
  </div>   
  </div>

    <div class="col-md-3">
      <div class="form-outline">
          <input type="text" id="requisicion" name="requisicion" value="{{ old('requisicion',isset($requi) ? $requi->requisicion : '' )}}" class="form-control text-uppercase"/>
          <label class="form-label">REQUISICIÓN</label>
      </div>
  </div>

  <div class="col-md-3">
    <div class="form-outline">
        <input type="date" id="fecha_requi" name="fecha_requi" value="{{ old('fecha_requi',isset($requi) ? $requi->fecha_requi : '' )}}" class="form-control text-uppercase"/>
        <label class="form-label">FECHA DE REQUISICIÓN</label>
    </div>
</div>

<div class="col-md-3">
  <div class="form-outline">
      <select class="form-select" name="prioridad" id="prioridad">
      <option value="ALTA" {{old('prioridad',isset($requi) && $requi->prioridad == 'ALTA' ? 'selected':'')}}>ALTA</option>
      <option value="MEDIA" {{old('prioridad',isset($requi) && $requi->prioridad == 'MEDIA' ? 'selected':'')}}>MEDIA</option>
      <option value="BAJA" {{old('prioridad',isset($requi) && $requi->prioridad == 'BAJA' ? 'selected':'')}}>BAJA</option>
      </select>
      <label class="form-label">PRIORIDAD</label>
</div>   
</div>
    

</div>

<!-- Segunda fila -->
<div class="row mb-4">  

  <div class="row mb-4">
    <div class="col-md-6">
      <div class="form-outline">
          <input type="text" id="comentario" name="comentario" value="{{ old('comentario',isset($requi) ? $requi->comentario : '' )}}" class="form-control text-uppercase" placeholder="PUEDES PONER INFO DE LAS OC"/>
          <label class="form-label">COMENTARIO</label>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="form-outline">
        <select class="form-select" name="orden_compra" id="orden_compra">
        <option value="COTIZANDO" {{old('orden_compra',isset($requi) && $requi->orden_compra == 'COTIZANDO' ? 'selected':'')}}>COTIZANDO</option>
        <option value="CREADA(S)" {{old('orden_compra',isset($requi) && $requi->orden_compra == 'CREADA(S)' ? 'selected':'')}}>CREADA(S)</option>
        </select>
        <label class="form-label">ORDEN DE COMPRA</label>
  </div>   
  </div>

  <div class="col-md-3">
    <div class="form-outline">
        <input type="date" id="fecha_coti" name="fecha_coti" value="{{ old('fecha_coti',isset($requi) ? $requi->fecha_coti : '' )}}" class="form-control text-uppercase"/>
        <label class="form-label">FECHA DE COTIZACIÓN</label>
    </div>
</div>

<div class="col-md-3">
  <div class="form-outline">
      <select class="form-select" name="status_oc" id="status_oc">
      <option value="PENDIENTE PAGO" {{old('status_oc',isset($requi) && $requi->status_oc == 'PENDIENTE PAGO' ? 'selected':'')}}>PENDIENTE PAGO</option>
      <option value="PAGADA" {{old('status_oc',isset($requi) && $requi->status_oc == 'PAGADA' ? 'selected':'')}}>PAGADA</option>
      <option value="CANCELADA" {{old('status_oc',isset($requi) && $requi->status_oc == 'CANCELADA' ? 'selected':'')}}>CANCELADA</option>
      <option value="EN PAUSA" {{old('status_oc',isset($requi) && $requi->status_oc == 'EN PAUSA' ? 'selected':'')}}>EN PAUSA</option>
      <option value="VENCIDA" {{old('status_oc',isset($requi) && $requi->status_oc == 'VENCIDA' ? 'selected':'')}}>VENCIDA</option>
      </select>
      <label class="form-label">STATUS DE OC</label>
</div>   
</div>

</div>


<br>
 <!-- Submit button -->
 <div class="row mb-4 col-md-6">

 <button type="submit" class="btn btn-primary btn-block col-md-3 m-1">{{$modo}} Requisiciones</button>
 
 <button type="button" class="btn btn-warning btn-block col-md-3 m-1"> <a class="text-white" href="{{ url('requisiciones-beta/') }}">
    Regresar
</a> </button> 

 </div>