@extends('layouts.app')
@section('indextax')

<div class="container">
 @if(Session::has('message'))
 {{Session::get('message')}}
 @endif   

 <button type="button" class="btn btn-outline-success mb-3 mt-3 m-2"> <a class="text-dark" href="{{ url('proveedores/') }}">
    Regresar
</a> </button> 

<button type="button" class="btn btn-outline-success mb-3 mt-3"> <a class="text-dark" href="{{ url('proveedores/create') }}">
    Agregar Proveedor
</a> </button> 


<div class="container">
    
    <h1>Proveedores</h1>
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>Nombre</th>
            <th>RFC</th>
            <th>Critico</th>
            <th>Divisa</th>
            <th>Dias de Credito</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($Suppliers as $supplier)
        <tr>
            <td>{{$supplier->name}}</td>
            <td>{{$supplier->rfc}}</td>
            <td>{{ $supplier->critic ? 'SI' : 'NO' }}</td>
            <td>{{$supplier->currency}}</td>
            <td>{{$supplier->credit_days}}</td> 
            <td>
               <button class="btn btn-warning mb-2"> <a class="text-white" href="{{ url('proveedores/'.$supplier->id.'/edit') }}">
                    Editar
                </a> </button> 
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{!! $Suppliers->links() !!}
</div>
</div>

@endsection
