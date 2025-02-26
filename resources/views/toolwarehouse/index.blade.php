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
    <a href="{{ url('almacen-herramientas/create') }}" class="col-md-3 btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        Agregar Herramienta
    </a>

    <a href="{{ url('/historial-almacen') }}" class="col-md-3 btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        Historial de Cambios
    </a>

    <a href="{{ url('/#') }}" class="col-md-3 btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        Exportar inventario a Excel
    </a>
</div>

<div class="col-md-12">

    <a href="{{ url('familias') }}" class="col-md-3 btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        Familias de HTAS
    </a>

    <a href="{{ url('subgrupos') }}" class="col-md-3 btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        Subgrupos de HTAS
    </a>

    <a href="{{ url('toolstatus') }}" class="col-md-3 btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        Status de HTAS
    </a>

    <a href="{{ url('bases') }}" class="col-md-3 btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        Bases
    </a>

</div>
 
<h3 class="text-center my-1">ALMACEN DE HERRAMIENTAS</h3>


<div class="card">
    <div class="card-body">
            
    <div class="table-responsive">
    <table id="herramientas" class="table table-light table-bordered table-hover text-center">
<thead class="thead-light">
        <tr>
            <th class="col-md-1">ID</th>
            <th class="col-md-1">FAMILIAS</th>
            <th class="col-md-1">DESCRIPCIÓN</th>
            <th class="col-md-1">N.SERIE</th>
            <th class="col-md-1">BASE OPE</th>
            <th class="col-md-1">STATUS</th>
            <th class="col-md-1">COMENTARIO</th>
            <th class="col-md-1">OPCIONES</th>

        </tr>
    </thead>
    <tbody>
        @foreach($toolwarehouse as $tool)
        <tr>
            <td>{{ $tool->id }}</td>
            <td>{{ $tool->families->name }}</td>
            <td>{{ $tool->description }}</td>
            <td>{{ $tool->serienum }}</td>
            <td>{{ $tool->bases->name }}</td>
            <td>{{ $tool->serienum }}</td>
            <td>{{ $tool->toolstatus->name }}</td>
            <td>{{ $tool->comentary }}</td>
            <td>
                <a class="text-white" href="{{ url('almacen-herramientas/'.$tool->id) }}">
                    <button class="btn btn-primary mb-2">
                        VER
                    </button>
                </a> 
                <a class="text-white" href="{{ url('almacen-herramientas/'.$tool->id.'/edit') }}">
                    <button class="btn btn-success mb-2">
                        Editar
                    </button>
                </a>
            </td>
            
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
        $('#herramientas').DataTable({
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