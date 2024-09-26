@extends('layouts.app')
@section('indexcondition')

<div class="container">
    <br>
    <form action="{{ url('/almacenherramientas/' . $toolwarehouse->id) }}" method="get" enctype="multipart/form-data">
        @csrf
 <H1>Informacion de Herramienta</H1>
  <!-- Primera fila -->
  <div class="row mb-4">
    <div class="col-md-3">
        <div class="form-outline">
            <input class="form-control" type="text" value="{{$toolwarehouse->family->name}}" readonly>
            <label class="form-label" for="family_id">Familia</label>
        </div>
    </div>


      <div class="col-md-3">
         <div class="form-outline">
            <input class="form-control" type="text" value="{{$toolwarehouse->subgroup->name}}" readonly>
            <label class="form-label" for="subgroup_id">Subgrupo</label>
         </div>
      </div>

      <div class="col-md-3">
          <div class="form-outline">
              <input class="form-control" type="text" value="{{$toolwarehouse->description}}" readonly>
              <label class="form-label" for="description">Descripción</label>
          </div>
      </div>

      <div class="col-md-3">
        <div class="form-outline">
            <input class="form-control" type="text" value="{{$toolwarehouse->serienum}}" readonly>
            <label class="form-label" for="serienum">Numero de serie</label>
        </div>
    </div>

  </div>

  <!-- Segunda fila -->
  <div class="row mb-4">
      
      <div class="col-md-3">
        <div class="form-outline">
            <input class="form-control" type="text" value="{{$toolwarehouse->base->name}}" readonly>
           <label class="form-label"  for="base_id">Base Operativa</label>
        </div>
    </div>

    <div class="col-md-3">
        <input class="form-control" type="text" value="{{$toolwarehouse->toolstatus->name}}" readonly>
        <label class="form-label"  for="base_id">Status de la herramienta</label>
  </div>

      <div class="col-md-3">
          <div class="form-outline">
              <input class="form-control" type="text" value="{{$toolwarehouse->extdia}}" readonly>
              <label class="form-label" for="extdia">Diametro exterior</label>
          </div>
      </div>

      <div class="col-md-3">
        <div class="form-outline">
            <input class="form-control" type="text" value="{{$toolwarehouse->insdia}}" readonly>
            <label class="form-label" for="insdia">Diametro interior</label>
        </div>
    </div>
  </div>

  <!-- Tercera fila -->
  <div class="row mb-4">
      
      <div class="col-md-3">
          <div class="form-outline">
              <input class="form-control" type="text" value="{{$toolwarehouse->fishingneck}}" readonly>
              <label class="form-label" for="fishingneck">Cuello de pesco</label>
          </div>
      </div>

      <div class="col-md-3">
          <div class="form-outline">
              <input class="form-control" type="text" value="{{$toolwarehouse->conpin}}" readonly>
              <label class="form-label" for="conpin">Pin de conexión</label>
          </div>
      </div>

    <div class="col-md-3">
      <div class="form-outline">
          <input class="form-control" type="text" value="{{$toolwarehouse->guidia}}" readonly>
          <label class="form-label" for="guidia">Diametro de guia</label>
      </div>
  </div>

  <!-- Cuarta fila -->
  
  <div class="row mb-4">
      <div class="col-md-3">
          <div class="form-outline">
              <input class="form-control" type="text" value="{{$toolwarehouse->conbox}}" readonly>
              <label class="form-label" for="conbox">Conexión Box</label>
          </div>
      </div>

      <div class="col-md-3">
          <div class="form-outline">
              <input class="form-control" type="text" value="{{$toolwarehouse->opera}}" readonly>
              <label class="form-label" for="opera">Rango de operación</label>
          </div>
      </div>

      <div class="col-md-3">
          <div class="form-outline">
              <input class="form-control" type="text" value="{{$toolwarehouse->length}}" readonly>
              <label class="form-label" for="length">Longitud</label>
          </div>
      </div>
  </div>

  <!-- Quinta fila -->
  <div class="row mb-4">
      <div class="col-md-4">
          <div class="form-outline">
              <input class="form-control" type="text" value="{{$toolwarehouse->necklength}}" readonly>
              <label class="form-label" for="necklength">Longitud de cuello</label>
          </div>
      </div>

      <div class="col-md-4">
          <div class="form-outline">
              <input class="form-control" type="text" value="{{$toolwarehouse->lastinsp}}" readonly>
              <label class="form-label" for="lastinsp">Folio ultima inspección</label>
          </div>
      </div>

      <div class="col-md-4">
          <div class="form-outline">
              <input class="form-control" type="text" value="{{$toolwarehouse->datelastinsp}}" readonly>
              <label class="form-label" for="datelastinsp">Fecha de ultima inspección</label>
          </div>
      </div>
  </div>

  <!-- Sexta fila -->
  <div class="row mb-4">
      <div class="col-md-4">
          <div class="form-outline">
              <input class="form-control" type="text" value="{{$toolwarehouse->outfolio}}" readonly>
              <label class="form-label" for="outfolio">Folio de salida</label>
          </div>
      </div>

      <div class="col-md-4">
          <div class="form-outline">
              <input class="form-control" type="text" value="{{$toolwarehouse->departuredate}}" readonly>
              <label class="form-label" for="departuredate">Fecha de salida</label>
          </div>
      </div>

     
  </div>

  <!-- Séptima fila -->
  <div class="row mb-4">
      <div class="col-md-4">
          <div class="form-outline">
              <input class="form-control" type="text" value="{{$toolwarehouse->comentary}}" readonly>
              <label class="form-label" for="comentary">Comentario</label>
          </div>
      </div>

      <div class="col-md-4">
          <div class="form-outline">
              <input class="form-control" type="text" value="{{$toolwarehouse->intloca}}" readonly>
              <label class="form-label" for="intloca">Localización interna</label>
          </div>
      </div>

      <div class="col-md-4">
          <div class="form-outline">
              <input class="form-control" type="text" value="{{$toolwarehouse->QR}}" readonly>
              <label class="form-label" for="QR">QR</label>
          </div>
      </div>
  </div>
</form>

<h2>Historial de Cambios</h2>

<table class="table">
    <thead>
        <tr>
            <th>Campo</th>
            <th>Valor Anterior</th>
            <th>Valor Nuevo</th>
            <th>Cambiado Por</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($toolwarehouse->histories as $history)
        <tr>
            <td>{{ $history->field }}</td>
            <td>{{ $history->old_value }}</td>
            <td>{{ $history->new_value }}</td>
            <td>{{ $history->user->name }}</td>
            <td>{{ $history->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>




   <!-- Submit button -->
   <div class="col-md-4">
 <button type="button" class="btn btn-warning btn-block mb-4"> <a class="text-white" href="{{ url('almacenherramientas/') }}">
    Regresar
</a> </button> 
</div>


</div>

@endsection
