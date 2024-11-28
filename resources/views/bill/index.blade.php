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
    <h2 class="text-center my-4">COBRANZA</h2>
    <div class="row">
        <!-- Card 1: Total pendiente de facturar (Privadas) -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-primary shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-file-earmark-text-fill me-3 icon-style"></i>
                        <h5 class="card-title mb-0">Privadas: Pendiente de Facturar</h5>
                    </div>
                    <p class="card-text display-6 mt-3">${{ number_format($totalPrivadasPendienteFacturar, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Card 2: Total pendiente de cobrar vencido (Privadas) -->
        <div class="col-md-4 mb-4">
            <a href="{{ route('privadas-vencidas') }}" class="text-decoration-none">
                <div class="card text-white bg-danger shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill me-3 icon-style"></i>
                            <h5 class="card-title mb-0">Privadas Facturado Vencido : Pendiente de Cobro</h5>
                        </div>
                        <p class="card-text display-6 mt-3">${{ number_format($totalPrivadasVencidas, 2) }}</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Card 3: Total pendiente de cobrar NO vencido (Privadas) -->
        <div class="col-md-4 mb-4">
            <a href="{{ route('privadas-no-vencidas') }}" class="text-decoration-none">
                <div class="card text-white bg-success shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-clock-fill me-3 icon-style"></i>
                            <h5 class="card-title mb-0">Privadas Facturado No Vencido: Pendiente de Cobro</h5>
                        </div>
                        <p class="card-text display-6 mt-3">${{ number_format($totalPrivadasNoVencidas, 2) }}</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Card 4: Total pendiente de facturar (Pemex) -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-primary shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-file-earmark-text-fill me-3 icon-style"></i>
                        <h5 class="card-title mb-0">PEMEX: Pendiente de Facturar</h5>
                    </div>
                    <p class="card-text display-6 mt-3">${{ number_format($totalPublicasPendienteFacturar, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Card 5: Total vencido (Pemex) -->
        <div class="col-md-4 mb-4">
            <a href="{{ route('publicas-vencidas') }}" class="text-decoration-none">
                <div class="card text-white bg-danger shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill me-3 icon-style"></i>
                            <h5 class="card-title mb-0">PEMEX Facturado Vencido: Pendiente de Cobro</h5>
                        </div>
                        <p class="card-text display-6 mt-3">${{ number_format($totalPublicasVencidas, 2) }}</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Card 6: Total pendiente de cobrar NO vencido (Pemex) -->
        <div class="col-md-4 mb-4">
            <a href="{{ route('publicas-no-vencidas') }}" class="text-decoration-none">
                <div class="card text-white bg-success shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-clock-fill me-3 icon-style"></i>
                            <h5 class="card-title mb-0">PEMEX Facturado No Vencido: Pendiente de Cobro</h5>
                        </div>
                        <p class="card-text display-6 mt-3">${{ number_format($totalPublicasNoVencidas, 2) }}</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
<!-- Button Section -->
<div class="d-flex justify-content-center flex-wrap mt-3">
    <a href="{{ route('empresas.privadas') }}" class="btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        Empresas Privadas
    </a>
    <a href="{{ route('empresas.publicas') }}" class="btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        Contratos con PEMEX
    </a>
    <a href="{{ url('empresas/') }}" class="btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        Crear Empresas
    </a>
    <a href="{{ url('divisas/') }}" class="btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        Tipo de Cambio
    </a>
    <a href="{{ route('export.empresas') }}" class="btn btn-lg btn-primary border-0 text-white shadow-sm m-2 w-auto">
        Resumen General Excel
    </a>
    <a href="{{ route('export.resumen-semanal') }}" class="btn btn-lg btn-primary border-0 text-white shadow-sm m-2 w-auto">
        Resumen Semanal
    </a>
</div>

    
    <h3 class="text-center my-4">Facturas vencidas</h3>
    
    
    <div class="card">
        <div class="card-body">
                
        <div class="table-responsive">
        <table id="vencidasall" class="table table-light table-bordered table-hover text-center">
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
            <td>{{ \Carbon\Carbon::parse($factura->bill_date)->format('d/m/Y')}}</td>
            <td>{{ \Carbon\Carbon::parse($factura->entry_date)->format('d/m/Y')}}</td>
            <td>{{ \Carbon\Carbon::parse($factura->expiration_date)->format('d/m/Y')}}</td>
            <td class="table-danger {{$factura->diasExpirados >= 0 ? 'red' : 'black'}}">{{floor($factura->diasExpirados)}}</td>
            <td>${{number_format($factura->total_payment,2,'.',',')}}</td>            
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