@extends('layouts.app')
@section('indexclient')

<div class="container">
 @if(Session::has('message'))
 {{Session::get('message')}}
 @endif   

 @push('css')
 <!-- CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.bootstrap5.css">
@endpush

<div class="container">
    <h2>COBRANZA</h2>
    <div class="container my-4">
        <div class="row">
    
            <!-- Card 1: Total pendiente de facturar (Privadas) -->
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Privadas: Pendiente de Facturar</h5>
                        <p class="card-text display-6">${{ number_format($totalPrivadasPendienteFacturar, 2) }}</p>
                    </div>
                </div>
            </div>
    
            <!-- Card 2: Total pendiente de cobrar vencido (Privadas) -->
            <div class="col-md-4">
                <a href="{{ route('privadas-vencidas') }}" class="text-decoration-none">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Privadas Facturado Vencido : Pendiente de Cobro</h5>
                        <p class="card-text display-6">${{ number_format($totalPrivadasVencidas, 2) }}</p>
                    </div>
                </div>
                </a>
            </div>
    
            <!-- Card 3: Total pendiente de cobrar NO vencido (Privadas) -->
            <div class="col-md-4">
                <a href="{{ route('privadas-no-vencidas') }}" class="text-decoration-none">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Privadas Facturado No Vencido: Pendiente de Cobro</h5>
                        <p class="card-text display-6">${{ number_format($totalPrivadasNoVencidas, 2) }}</p>
                    </div>
                </div>
                </a>
            </div>
    
            <!-- Card 4: Total pendiente de facturar (Pemex) -->
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">PEMEX: Pendiente de Facturar</h5>
                        <p class="card-text display-6">${{ number_format($totalPublicasPendienteFacturar, 2) }}</p>
                    </div>
                </div>
            </div>
    
            <!-- Card 5: Total vencido (Pemex) -->
            <div class="col-md-4">
                <a href=" {{route('publicas-vencidas')}} " class="text-decoration-none">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body">
                        <h5 class="card-title">PEMEX Facturado Vencido: Pendiente de Cobro</h5>
                        <p class="card-text display-6">${{ number_format($totalPublicasVencidas, 2) }}</p>
                    </div>
                </div>
                </a>
            </div>
    
            <!-- Card 6: Total pendiente de cobrar NO vencido (Pemex) -->
            <div class="col-md-4">
                <a href="{{ route('publicas-no-vencidas')}}" class="text-decoration-none">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">PEMEX Facturado No Vencido: Pendiente de Cobro</h5>
                        <p class="card-text display-6">${{ number_format($totalPublicasNoVencidas, 2) }}</p>
                    </div>
                </div>
                </a>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-outline-success mb-3 mt-3">
        <a class="text-dark text-decoration-none" href="{{ route('empresas.privadas') }}">
            Empresas Privadas
        </a>
    </button>

    <button type="button" class="btn btn-outline-success mb-3 mt-3 m-2"> <a class="text-dark text-decoration-none" href="{{ route('empresas.publicas') }}">
        Contratos con PEMEX
    </a> </button> 

    <button type="button" class="btn btn-outline-success mb-3 mt-3 m-2"> <a class="text-dark text-decoration-none" href="{{ url('empresas/') }}">
        Crear Empresas
    </a> </button> 

    <button type="button" class="btn btn-outline-success mb-3 mt-3 m-2"> <a class="text-dark text-decoration-none" href="{{ url('divisas/') }}">
        Tipo de cambio
    </a> </button> 

    <button type="button" class="btn btn-outline-info mb-3 mt-3 m-2"> <a class="text-dark text-decoration-none" href="{{ route('export.empresas') }}">
        Resumen General Excel
    </a> </button> 

    
    <h3>Facturas vencidas</h3>
    
    
    <div class="card">
        <div class="card-body">
                
        <div class="table-responsive">
        <table id="vencidasall" class="table table-light table-bordered table-hover">
    <thead class="thead-light">
        <tr>
            <th>CLIENTE</th>
            <th>NO.FACTURA</th>
            <th>FECHA FACTURA</th>
            <th>FECHA DE ENTRADA</th>
            <th>FECHA DE EXPIRACIÓN</th>
            <th>DIAS VENCIDOS</th>
            <th>TOTAL</th>
        </tr>
    </thead>
    <tbody>
        @foreach($facturas as $factura)
        <tr>
            <td>{{$factura->companyreceivable->name}}</td>
            <td>{{$factura->bill_number}}</td>
            <td>{{$factura->bill_date}}</td>
            <td>{{$factura->entry_date}}</td>
            <td>{{$factura->expiration_date}}</td>
            <td class="table-danger {{$factura->diasExpirados >= 0 ? 'red' : 'black'}}">{{floor($factura->diasExpirados)}}</td>
            <td>{{$factura->total_payment}}</td>            
        </tr>
        @endforeach
    </tbody>
</table>

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
        $('#vencidasall').DataTable({
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