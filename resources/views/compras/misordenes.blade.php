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

 

    <a href="{{ url('/mis-requisiciones') }}" class="btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        Mis requisiciones
    </a>

    
</div>
 
<h3 class="text-center my-4">Mis Ordenes de Compra</h3>


<div class="card">
    <div class="card-body">
            
    <div class="table-responsive">
    <table id="compras" class="table table-light table-bordered table-hover text-center">
<thead class="thead-light">
        <tr>
            <th class="col-md-1">REQ</th>
            <th class="col-md-1">OC</th>
            <th class="col-md-1">STATUS</th>
            <th class="col-md-1">PRIORIDAD</th>
            <th class="col-md-1">ELABORACIÓN DE OC</th>
            <th class="col-md-1">FECHA MAX DE RESPUESTA</th>
            <th class="col-md-1">DIAS VENCIDOS O POR VENCER </th>

        </tr>
    </thead>
    <tbody>
        @foreach($orderclient as $order)
        <tr>
            <td>{{ $order->requisition->id }}</td>          
            <td>{{ "VH-".$order->id."-". $order->created_at->format('y') }}</td>
            <td>{{ $order->po_status}}</td>

        <td class="
        @if(\Carbon\Carbon::parse($order->requisition->production_date)->diffInDays(now(), false) >= -15)
            table-danger text-danger fw-bold
        @elseif(\Carbon\Carbon::parse($order->requisition->production_date)->diffInDays(now(), false) >= -30)
            table-danger
        @elseif(\Carbon\Carbon::parse($order->requisition->production_date)->diffInDays(now(), false) >= -60)
            table-warning
        @else
            table-success
        @endif">
        @if(\Carbon\Carbon::parse($order->requisition->production_date)->diffInDays(now(), false) >= -15)
            ALTA 
        @elseif(\Carbon\Carbon::parse($order->requisition->production_date)->diffInDays(now(), false) >= -30)
            ALTA
        @elseif(\Carbon\Carbon::parse($order->requisition->production_date)->diffInDays(now(), false) >= -60)
            MEDIA
        @else
            BAJA
        @endif
    </td>
        <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</td>


        
        <td>{{ \Carbon\Carbon::parse($order->requisition->production_date)->format('d/m/Y') }}</td>
  
        <td class="
        @if(\Carbon\Carbon::parse($order->requisition->production_date)->diffInDays(now(), false) >= -15)
            table-danger text-danger fw-bold
        @elseif(\Carbon\Carbon::parse($order->requisition->production_date)->diffInDays(now(), false) >= -30)
            table-danger
        @elseif(\Carbon\Carbon::parse($order->requisition->production_date)->diffInDays(now(), false) >= -60)
            table-warning
        @else
            table-success
        @endif">
        {{ floor(\Carbon\Carbon::parse($order->requisition->production_date)->diffInDays(now(), false)) }}
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