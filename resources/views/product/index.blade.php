@extends('layouts.app')
@section('indextax')

<div class="container">
 @if(Session::has('message'))
 {{Session::get('message')}}
 @endif   

 <button type="button" class="btn btn-outline-success mb-3 mt-3 m-2"> <a class="text-dark" href="{{ url('productos/') }}">
    Regresar
</a> </button> 

<button type="button" class="btn btn-outline-success mb-3 mt-3"> <a class="text-dark" href="{{ url('productos/create') }}">
    Agregar Productos
</a> </button> 


<div class="container">
    
    <h1>Productos</h1>
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>Nombre</th>
            <th>UDM</th>
            <th>Precio Unitario</th>
            <th>Impuesto</th>
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
            <td>{{$product->precio}}</td>
            <td>{{$product->taxes_id}}</td>
            <td>{{$ $precio_total = $precio * (1 + $product->tax->percent);}} </td> 
            <td>{{$product->min_stock}}</td>
            <td>
               <button class="btn btn-warning mb-2"> <a class="text-white" href="{{ url('proveedores/'.$supplier->id.'/edit') }}">
                    Editar
                </a> </button> 
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{!! $Products->links() !!}
</div>
</div>

@endsection
