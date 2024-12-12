@extends('layouts.app')
@section('indexsupplier')

<div class="container">
 @if(Session::has('message'))
 {{Session::get('message')}}
 @endif   


 <button type="button" class="btn btn-outline-success mb-3 mt-3 m-2"> <a class="text-dark" href="{{ url('productos/') }}">
    Regresar
</a> </button> 

<button type="button" class="btn btn-outline-success mb-3 mt-3"> <a class="text-dark" href="{{ url('productos/create') }}">
    Agregar Producto
</a> </button> 


<div class="container">
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>IDENTIFICADOR INTERNO</th>
            <th>DESCRIPCION</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
            <td>{{ $product->internal_id }}</td>
            <td>{{ $supplier->description }}</td>
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

@endsection
