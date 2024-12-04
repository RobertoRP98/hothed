@extends('layouts.app')
@section('indextax')

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

<!-- Sección de Botones Generales -->
<div class="d-flex justify-content-center flex-wrap mt-3">

    <a href="{{ url('productos/') }}" class="btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        Regresar
    </a>

    <a href="{{ url('productos/create') }}" class="btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        Agregar Productos
    </a>
</div>

    
    <h1>Productos</h1>

    <div class="card">
        <div class="card-body">      
        <div class="table-responsive">
        <table id="productos" class="table table-light table-bordered table-hover text-center">
    <thead class="thead-light">
        <tr>
            <th>Nombre</th>
            <th>UDM</th>
            <th>Precio Unitario</th>
            <th>Impuesto</th>
            <th>Descuento</th>
            <th>Precio Total</th>
            <th>Stock Minimo</th>
            <th>Opciones</th>
        </tr>
    </thead>
    

    <tbody>
        @foreach($Products as $product)
        <tr>
            <td>{{$product->name}}</td>
            <td>{{$product->udm}}</td>
            <td>${{$product->precio}}</td>
            <td>{{$product->tax->name}}</td>
            <td>{{$product->discount}}%</td>
            <td>${{number_format( $product->precio * (1 - $product->discount / 100) * (1 + $product->tax->percent), 2 )}}</td> 
            <td>{{ $product->min_stock . ' ' . $product->udm }}</td>
            <td>
               <button class="btn btn-warning mb-2"> <a class="text-white" href="{{ url('productos/'.$product->id.'/edit') }}">
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
        $('#productos').DataTable({
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