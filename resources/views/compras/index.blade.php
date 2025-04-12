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
<h3>Datos Generales</h3>

    <a href="{{ url('/ordenes-compra/pendientes') }}" class="col-md-3 btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        Ordenes Pendientes de Autorización
    </a>

    <a href="{{ url('/ordenes-compra/rechazadas') }}" class="col-md-3 btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        Ordenes Canceladas 
    </a>

    <a href="{{ url('/ordenes-compra/finalizadas') }}" class="col-md-3 btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        Ordenes Finalizadas 
    </a>

    <a href="{{ url('/ordenes-compra/facturadas') }}" class="col-md-3 btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        Ordenes Facturadas
    </a>

    <a href="{{ url('/ordenes-compra/no-facturadas') }}" class="col-md-3 btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        Ordenes No Facturadas
    </a>

    <a href="{{ url('/ordenes-compra/pagadas') }}" class="col-md-3 btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        Ordenes Pagadas
    </a>
</div>

<h3>Descargar Excel</h3>

<!-- Botones de Excel -->
<div class="d-flex flex-wrap">

    <a href="{{ url('/export-compras-locales') }}" class="col-md-3 btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        REPORTE COMPRAS LOCALES
    </a>

    <a href="{{ url('/export-compras-extranjeras') }}" class="col-md-3 btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        REPORTE COMPRAS EXTRANJERAS
    </a>

    <a href="{{ url('/export-compras-global') }}" class="col-md-3 btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        REPORTE GLOBAL DE COMPRAS
    </a>

    <a href="{{ url('/export-resumen-semanal-compras') }}" class="col-md-3 btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        ORDENES CREADAS EN LA SEMANA
    </a>

    <a href="{{ url('/export-proveedores') }}" class="col-md-3 btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        PROVEEDORES APROBADOS
    </a>

    
 
</div>
 
<h3 class="text-center my-1">Ordenes de Compra Autorizadas</h3>


<div class="card">
    <div class="card-body">
            
    <div class="table-responsive">
    <table id="compras" class="table table-light table-bordered table-hover text-center">
<thead class="thead-light">
        <tr>
            <th class="col-md-1">ID REQUI</th>
            <th class="col-md-1">ID ORDEN</th>
            <th class="col-md-1">DEP</th>
            <th class="col-md-1">PROVEEDOR</th>
            <th class="col-md-1">TOTAL</th>
            <th class="col-md-1">AUTORIZADO</th>
            <th class="col-md-1">PRIORIDAD</th>
            <th class="col-md-1">DIAS RESTANTES</th>
            <th class="col-md-1">STATUS OC</th>
            <th class="col-md-1">OPCIONES</th>

        </tr>
    </thead>
    <tbody>
        @foreach($datosoc as $oc)
        <tr>
            <td>{{ $oc->requisition->user->area ."-" . $oc->requisition->id }}</td>
            <td>{{ "VH-".$oc->id ."-". $oc->created_at->format('y')}}</td>
            <td>{{ $oc->requisition->user->area }}</td>
            <td>{{ $oc->supplier->name}}</td>
            <td>{{ $oc->total }}</td>
            <td>{{ $oc->authorization_4 }}</td> 
            <td class="
    @if(\Carbon\Carbon::parse($oc->requisition->production_date)->diffInDays(now(), false) >= -15)
        table-danger text-danger fw-bold
    @elseif(\Carbon\Carbon::parse($oc->requisition->production_date)->diffInDays(now(), false) >= -30)
        table-danger
    @elseif(\Carbon\Carbon::parse($oc->requisition->production_date)->diffInDays(now(), false) >= -60)
        table-warning
    @else
        table-success
    @endif">
    @if(\Carbon\Carbon::parse($oc->requisition->production_date)->diffInDays(now(), false) >= -15)
        ALTA
    @elseif(\Carbon\Carbon::parse($oc->requisition->production_date)->diffInDays(now(), false) >= -30)
        ALTA
    @elseif(\Carbon\Carbon::parse($oc->requisition->production_date)->diffInDays(now(), false) >= -60)
        MEDIA
    @else
        BAJA
    @endif
</td>
        
      
            <td class="
            @if(\Carbon\Carbon::parse($oc->requisition->production_date)->diffInDays(now(), false) >= -15)
                table-danger text-danger fw-bold
            @elseif(\Carbon\Carbon::parse($oc->requisition->production_date)->diffInDays(now(), false) >= -30)
                table-danger
            @elseif(\Carbon\Carbon::parse($oc->requisition->production_date)->diffInDays(now(), false) >= -60)
                table-warning
            @else
                table-success
            @endif">
            {{ floor(\Carbon\Carbon::parse($oc->requisition->production_date)->diffInDays(now(), false)) }}
        </td>

        <td>{{ $oc->po_status }}</td> 

        

            <td>
                <a class="text-white" href="{{ route('ordencompra.show', ['purchaseOrder' => $oc->id, 'requisicione' => $oc->requisition->id]) }}" target="_blank">

                    <button class="btn btn-primary mb-2">
                        VER
                    </button>
                </a> 
                <a class="text-white" href="{{ route('ordencompra.edit', ['purchaseOrder' => $oc->id, 'requisicione' => $oc->requisition->id]) }}" target="_blank"

                    >
                    <button class="btn btn-success mb-2">
                        Editar
                    </button>
                </a>
                <a class="text-white" href="{{ route('ordencompra.pdf', ['purchaseOrder' => $oc->id, 'requisicione' => $oc->requisition->id]) }}">

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
            order: [[1, 'desc']],

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