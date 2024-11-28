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

 <button type="button" class="btn btn-outline-success mb-3 mt-3 m-2">
    <a class="text-dark text-decoration-none" href="{{ url('catalogo/' . $comp->id) }} ">
        Regresar
    </a>
</button>

<h2>Facturas Pagadas</h2>
<div class="card">
    <div class="card-body">
<div class="table-responsive">
    <table id="pagadas" class="table table-light table-bordered table-hover">
        <thead class="thead-light">
            <tr>
                <th>Fecha de pago</th>
                <th>No. Factura</th>
                <th>Fecha de Factura</th>
                <th>Fecha de Ingreso</th>
                <th>Fecha de Expiración</th>
                <th>Días Vencidos o por vencer</th>
                <th>Total</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($paidBills as $bill)
                <tr>
                    <td>
                        {{ $bill->payment_day ? \Carbon\Carbon::parse($bill->payment_day)->format('d-m-Y') : 'SIN FECHA ASIGNADA' }}
                    </td>
                    <td>{{ $bill->bill_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($bill->bill_date)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($bill->entry_date)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($bill->expiration_date)->format('d-m-Y') }}</td>
                    <td class="
                    @if($bill->status==='pagado')
                        table-info
                    @elseif(\Carbon\Carbon::parse($bill->expiration_date)->diffInDay(now(),false)>=0)
                        table-danger 
                    @elseif(\Carbon\Carbon::parse($bill->expiration_date)->diffInDay(now(),false)<=-31)
                        table-secondary
                    @else
                        table-warning        
                    @endif    
                    ">
                    {{floor(\Carbon\Carbon::parse($bill->expiration_date)->diffInDay(now(),false))}}
                    </td>
                    <td>{{$bill->total_payment}}</td>
                    
                    <td>
                        <button class="btn btn-warning mb-2">
                            <a class="text-white" href="{{ route('facturas.edit', [$comp->id, $bill->id]) }}">Editar Factura</a> 
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
        $('#pagadas').DataTable({
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