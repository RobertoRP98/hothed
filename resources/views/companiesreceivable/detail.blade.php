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

    <h1>{{ $empresa->name }}</h1>

    <div class="mb-3">
        <!-- Botones generales -->
        <div class="d-flex flex-wrap mb-4">
            <a 
                @if($empresa->type == 'Privada')
                href="{{route('empresas.privadas')}}"
                @else
                href="{{route('empresas.publicas')}}"
                @endif
                class="btn btn-outline-success m-2 text-decoration-none text-dark">
                Regresar
            </a>
    
            <a href="{{ route('prefactura.create', ['companyreceivable_id' => $empresa->id]) }}" 
               class="btn btn-outline-success m-2 text-decoration-none text-dark">
                Crear nuevo
            </a>
    
            <a href="{{route('empresa.historial', ['company' => $empresa->id]) }}" 
               class="btn btn-outline-success m-2 text-decoration-none text-dark">
                Historial General
            </a>
    
            <a href="{{route('empresa.facturas-pagadas', ['company' => $empresa->id]) }}" 
               class="btn btn-outline-success m-2 text-decoration-none text-dark">
                Historial pagados
            </a>
    
            <button type="button" id="resetFilter" class="btn btn-outline-success m-2">
                Restablecer filtro
            </button>
        </div>
    
    <h3>Descargar Excel</h3>

        <!-- Botones de Excel -->
        <div class="d-flex flex-wrap">
            <a href="{{ route('empresas.export', $empresa->id) }}" 
               class="btn btn-outline-success m-2 text-decoration-none text-dark">
                Descargar Excel General
            </a>
    
            <a href="{{ route('empresas.export.pf', $empresa->id) }}" 
               class="btn btn-outline-success m-2 text-decoration-none text-dark">
                Descargar Excel Pendiente Facturar
            </a>
    
            <a href="{{ route('empresas.export.pc', $empresa->id) }}" 
               class="btn btn-outline-success m-2 text-decoration-none text-dark">
                Descargar Excel Pendiente Cobrar
            </a>

            <a href="{{ route('empresas.export.pe', $empresa->id) }}" 
                class="btn btn-outline-success m-2 text-decoration-none text-dark">
                 Descargar Excel Pendiente Entrada
             </a>
        </div>
    </div>



    <h2>Totales</h2>
    <div class="container my-4">
        <div class="row">

            <div class="col-md-6">
                <div id="filterPendingFacturar" class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Pendiente de facturar: </h5>
                        <p class="card-text display-6">${{ number_format($totalPendienteFacturar, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div id="filterPendingCobro" class="card text-white bg-danger mb-3">
                    <div class="card-body">
                        <h5 class="card-title"> Facturado Pendiente de Cobro: </h5>
                        <p class="card-text display-6">${{ number_format($totalPendienteCobrar, 2) }}</p>
                    </div>
                </div>
            </div>

            {{-- <div class="col-md-6">
                <div class="card text-white bg-secondary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Historico: </h5>
                        <p class="card-text display-6">${{ number_format($totalGlobal, 2) }}</p>
                    </div>
                </div>
            </div>
            

            <div class="col-md-6">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Pagado: </h5>
                        <p class="card-text display-6">${{ number_format($totalPagado , 2) }}</p>
                    </div>
                </div>
            </div> --}}


        </div>
    </div>

   

    <h2>Facturas</h2>

    <div class="card">
        <div class="card-body">
            
    <div class="table-responsive">
    <table id="detalles" class="table table-light table-bordered table-hover text-center">
    {{-- <table class="table table-striped" id="detalles"> --}}
        <thead class="thead-light">
            <tr>
                {{-- <th>No. Orden</th> --}}
                <th>No. Factura</th>
                <th>Fecha de Factura</th>
                <th>Fecha de Ingreso</th>
                <th>Fecha de Expiración</th>
                <th>Días Vencidos o por vencer</th>
                <th>Total</th>
                <th>Status</th>
                <th>Opciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($unpaidBills as $bill)
                <tr>
                    <td>{{ $bill->bill_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($bill->bill_date)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($bill->entry_date)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($bill->expiration_date)->format('d/m/Y') }}</td>
                    
                    <td class="
                        @if($bill->status === 'pagado')
                            table-info
                        @elseif(\Carbon\Carbon::parse($bill->expiration_date)->diffInDays(now(), false) >= 0)
                            table-danger 
                        @elseif(\Carbon\Carbon::parse($bill->expiration_date)->diffInDays(now(), false) <= -31)
                            table-secondary
                        @else
                            table-warning        
                        @endif">
                        {{ floor(\Carbon\Carbon::parse($bill->expiration_date)->diffInDays(now(), false)) }}
                    </td>

                    <td>${{ number_format($bill->total_payment, 2, '.', ',') }}</td>

                    <td>
                        @switch($bill->status)
                            @case('pendiente_cobrar')
                                Pendiente por Cobrar
                                @break
                            @case('pendiente_facturar')
                                Pendiente de Facturar
                                @break
                            @case('pendiente_entrada')
                                Pendiente de Entrada
                                @break
                            @default
                                {{ ucfirst($bill->status) }}
                        @endswitch
                    </td>

                    <td>
                        <button class="btn btn-warning mb-2">
                            <a class="text-white" href="{{ route('facturas.edit', [$empresa->id, $bill->id]) }}">Editar Factura</a> 
                        </button> 
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
        // Almacenar la instancia de DataTable en una variable
        var table = $('#detalles').DataTable({
            responsive: false,
            autoWidth: false,
            language: {
                lengthMenu: "Mostrar _MENU_ registros",
                loadingRecords: "Cargando...",
                processing: "",
                info: "Mostrando la página _PAGE_ de _PAGES_",
                search: "Buscar:",
                zeroRecords: "Registro no encontrado - Verifica el texto, elimina espacios al inicio y al final",
                paginate: {
                    first: "Inicio",
                    last: "Último",
                    next: "Siguiente",
                    previous: "Anterior"
                },
                aria: {
                    orderable: "Ordenado por esta columna",
                    orderableReverse: "Columna ordenada inversamente"
                }
            }
        });

        // Filtrar la tabla cuando se hace clic en la tarjeta "Facturado Pendiente de Cobro"
        $('#filterPendingCobro').on('click', function() {
            table.column(6) // Selecciona la columna del "Status" (índice basado en cero, ajusta si es necesario)
                .search('Pendiente por Cobrar', true, false) // Aplica el filtro de búsqueda con coincidencia exacta (o ajusta el valor exacto si difiere)
                .draw(); // Redibuja la tabla con el filtro aplicado
        });

        $('#filterPendingFacturar').on('click', function() {
            table.column(6) // Selecciona la columna del "Status" (índice basado en cero, ajusta si es necesario)
                .search('Pendiente de Facturar', true, false) // Aplica el filtro de búsqueda con coincidencia exacta (o ajusta el valor exacto si difiere)
                .draw(); // Redibuja la tabla con el filtro aplicado
        });

        // Restablecer filtro y restaurar la vista completa al hacer clic en "Restablecer filtro"
        $('#resetFilter').on('click', function() {
            table.search('').columns().search('').draw(); // Limpia todas las búsquedas y redibuja la tabla
        });
    });
</script>
@endpush