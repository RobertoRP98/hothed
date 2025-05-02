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
    <a href="{{ url('/ordenes-compra/autorizacion/autorizadas') }}" class="col-md-3 btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        COMPRAS AUTORIZADAS
    </a>

    <a href="{{ url('/ordenes-compra/autorizacion/canceladas') }}" class="col-md-3 btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        COMPRAS RECHAZADAS
    </a>
</div>
 
<h3 class="text-center my-1">COMPRAS PENDIENTES DE AUTORIZACIÓN</h3>


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
            <th class="col-md-1">AUTORIZACIÓN</th>
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
            {{-- <td>{{ "VH-".$oc->id ."-". $oc->created_at->format('y')}}</td> --}}
            <td data-order="{{ $oc->id }}">{{ "VH-".$oc->id ."-". $oc->created_at->format('y') }}</td>
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

        <td>
            @if($oc->po_status === 'PENDIENTE DE PAGO')
                PENDIENTE DE COMPRA/SERVICIO
            @elseif($oc->po_status === 'PENDIENTE DE PAGO (SERVICIO CONCLUIDO)')
                COMPRA/SERVICIO CONCLUIDO SIN PAGO
            @else
                {{ $oc->po_status }}
            @endif
        </td>
        

            <td>
                <a class="text-white" href="{{ route('ordencompra.show', ['purchaseOrder' => $oc->id, 'requisicione' => $oc->requisition->id]) }}" target="_blank">

                    <button class="btn btn-primary mb-2">
                        Ver
                    </button>
                </a> 
               
                <a class="text-white" href="{{ route('autdir.edit', ['purchaseOrder' => $oc->id, 'requisicione' => $oc->requisition->id]) }}" target="_blank"
                    >
                    <button class="btn btn-success mb-2">
                        Autorizar
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