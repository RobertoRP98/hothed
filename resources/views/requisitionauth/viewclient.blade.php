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


<div class="d-flex flex-wrap mt-3">

    @php
    $roleRedirects = [
        'Developer' => '/requisiciones',
        'RespCompras' => '/requisiciones',
        // Aprobadores
        'Coordconta' => '/requisiciones-contabilidad',
        'Coordalm' => '/requisiciones-almacen',
        'Subgerope' => '/requisiciones-subope',
        'Gerope' => '/requisiciones-gerope',
        'Respsgi' => '/requisiciones-sgi',
        'Diradmin' => '/requisiciones-administracion',
        'Dirope' => '/requisiciones-dirope',
        'Coordcontratos' => '/requisiciones-contratos',
    ];
    
   // Obtener el primer rol válido del usuario
   $userRole = optional(auth()->user()->roles->pluck('name')->intersect(array_keys($roleRedirects)))->first();
@endphp

@if ($userRole)
    <a class="btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto" href="{{ url($roleRedirects[$userRole]) }}">
        Mi Equipo
    </a>
@endif

    <a href="{{ url('requisiciones/create') }}" class="btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        Agregar Requisición
    </a>

    <a href="{{ url('/mis-ordenes') }}" class="btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        Mis Ordenes de Compra
    </a>

    <a href="{{ url('/productos-cliente') }}" class="btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        Ver Productos Autorizados
    </a>

    
</div>
 
<h3 class="text-center my-4">Mis Requisiciones</h3>


<div class="card">
    <div class="card-body">
            
    <div class="table-responsive">
    <table id="compras" class="table table-light table-bordered table-hover text-center">
<thead class="thead-light">
        <tr>
            <th class="col-md-1">REQ.#</th>
            <th class="col-md-1">STATUS</th>
            <th class="col-md-1">PRIORIDAD</th>
            <th class="col-md-1">FINALIZADO</th>
            <th class="col-md-1">INGRESO</th>
            <th class="col-md-1">FECHA MAX DE RESPUESTA</th>
            <th class="col-md-1">DIAS VENCIDOS O POR VENCER </th>
            <th class="col-md-1">OPCIONES</th>

        </tr>
    </thead>
    <tbody>
        @foreach($requisitionclient as $requisicion)
        <tr>
            <td>{{ $requisicion->id }}</td>
            <td>{{ $requisicion->status_requisition }}</td>

            <td class="
            @if(\Carbon\Carbon::parse($requisicion->production_date)->diffInDays(now(), false) >= -15)
                table-danger text-danger fw-bold
            @elseif(\Carbon\Carbon::parse($requisicion->production_date)->diffInDays(now(), false) >= -30)
                table-danger
            @elseif(\Carbon\Carbon::parse($requisicion->production_date)->diffInDays(now(), false) >= -60)
                table-warning
            @else
                table-success
            @endif">
            @if(\Carbon\Carbon::parse($requisicion->production_date)->diffInDays(now(), false) >= -15)
                ALTA 
            @elseif(\Carbon\Carbon::parse($requisicion->production_date)->diffInDays(now(), false) >= -30)
                ALTA
            @elseif(\Carbon\Carbon::parse($requisicion->production_date)->diffInDays(now(), false) >= -60)
                MEDIA
            @else
                BAJA
            @endif
        </td>
        <td>{{ $requisicion->finished ? 'SI' : 'NO' }}</td>
        <td>{{ \Carbon\Carbon::parse($requisicion->request_date)->format('d/m/Y') }}</td>
        <td>{{ \Carbon\Carbon::parse($requisicion->production_date)->format('d/m/Y') }}</td>
  
        <td class="
        @if(\Carbon\Carbon::parse($requisicion->production_date)->diffInDays(now(), false) >= -15)
            table-danger text-danger fw-bold
        @elseif(\Carbon\Carbon::parse($requisicion->production_date)->diffInDays(now(), false) >= -30)
            table-danger
        @elseif(\Carbon\Carbon::parse($requisicion->production_date)->diffInDays(now(), false) >= -60)
            table-warning
        @else
            table-success
        @endif">
        {{ floor(\Carbon\Carbon::parse($requisicion->production_date)->diffInDays(now(), false)) }}
    </td>
    
            <td>
                <a class="text-white" href="{{ url('requisiciones/'.$requisicion->id) }}">
                    <button class="btn btn-primary mb-2">
                        VER
                    </button>
                </a> 

                <a class="text-white" href="{{ url('requisiciones/'.$requisicion->id . '/pdf') }}">
                    <button class="btn btn-secondary mb-2">
                        PDF
                    </button>
                </a> 
            </td>
            
        </tr>
        @endforeach
    </tbody>
</table>
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
        $('#compras').DataTable({
            resposive:true,
            autoWidth: false,
            order: [[0, 'desc']],

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