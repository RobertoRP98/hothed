@extends('layouts.app')
@section('indexsupplier')

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


<div class="d-flex flex-wrap mt-3">
    <a href="{{ url('/productos') }}" class="btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        Regresar
    </a>

    <a href="{{ url('proveedores/create') }}" class="btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        Agregar Proveedor
    </a>

   
</div>


<h3 class="text-center my-4">Productos</h3>


<div class="card">
    <div class="card-body">
            
    <div class="table-responsive">
    <table id="suppliers" class="table table-light table-bordered table-hover text-center">
<thead class="thead-light">
        <tr>
            <th>NOMBRE</th>
            <th>RFC</th>
            <th>STATUS</th>
            <th>LINEA</th>
            <th>NOTAS</th>
            <th>OPCIONES</th>

        </tr>
    </thead>
    <tbody>
        @foreach($suppliers as $supplier)
        <tr>
            <td>{{ $supplier->name }}</td>
            <td>{{ $supplier->rfc }}</td>
            <td>{{ $supplier->status }}</td>
            <td>{{ $supplier->product_type }}</td>
            <td>{{ $supplier->notes }}</td>

            <td>
               <button class="btn btn-warning mb-2"> <a class="text-white" href="{{ url('proveedores/'.$supplier->id.'/edit') }}">
                    Editar
                </a> </button> 
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
        $('#suppliers').DataTable({
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