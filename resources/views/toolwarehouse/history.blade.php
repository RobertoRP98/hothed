@extends('layouts.app')
@section('indexsupplier')

<div class="container">
 @if(Session::has('message'))
 {{Session::get('message')}}
 @endif
 
 
 @if(request()->has('message'))
    <div class="alert alert-success">
        {{ request('message') }}
    </div>
@endif


 @push('css')
 <!-- CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.bootstrap5.css">
@endpush

<div class="col-md-12">

    <a href="{{ url('/almacen-herramientas') }}" class="col-md-3 btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        Almacen de Herramientas
    </a>

</div>
 
<h3 class="text-center my-1">HISTORIAL DE CAMBIOS</h3>


<div class="card">
    <div class="card-body">
            
    <div class="table-responsive">
    <table id="historial-herramientas" class="table table-light table-bordered table-hover text-center">
<thead class="thead-light">
        <tr>
            <th>HERRAMIENTA</th>
            <th> N.SERIE </th> 
            <th>CAMPO CAMBIADO</th>
            <th>VALOR ANTERIOR</th>
            <th>VALOR NUEVO</th>
            <th>CAMBIADO POR </th>
            <th>FECHA MODIFICACIÓN </th>
        </tr>
    </thead>
    <tbody>
        @foreach($histories as $history)
        <tr>
            <td>{{ $history->toolwarehouse->description}}</td>
            <td>{{ $history->toolwarehouse->serienum}}</td>
            <td>{{ $history->field }}</td>
            <td>{{ $history->old_value }}</td>
            <td>{{ $history->new_value }}</td>
            <td>{{ $history->user->name }}</td>
            <td>{{ $history->updated_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
</div>
</div>
</div>

@endsection

@push('js')
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<!-- JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.3/js/responsive.bootstrap5.js"></script>

<script>
    $(document).ready(function() {
        $('#historial-herramientas').DataTable({
            resposive:true,
            autoWidth: false,

            "language": {
                "lengthMenu":     "Mostrar _MENU_ registros",
    "loadingRecords": "Cargando...",
    "processing":     "",
    "info": "Mostrando la página _PAGE_ de _PAGES_",
    "search":         "Buscar:",
    "zeroRecords":    "Registro no encontrado - Verifica el texto, elimina espacios al inicio y al final",
    "paginate": {
        "first":      "Inicio",
        "last":       "Ultimo",
        "next":       "Siguiente",
        "previous":   "Anterior"
    },
    "aria": {
        "orderable":  "Ordenado por esta columna",
        "orderableReverse": "Columna ordenada inversamente"
    }
            }
        }); // Asegúrate de que el ID coincida con tu tabla
    });
</script>
@endpush