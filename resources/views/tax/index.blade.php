@extends('layouts.app')
@section('indextax')

<div class="container">
 @if(Session::has('message'))
 {{Session::get('message')}}
 @endif   

 <button type="button" class="btn btn-outline-success mb-3 mt-3 m-2"> <a class="text-dark" href="{{ url('impuestos/') }}">
    Regresar
</a> </button> 

<button type="button" class="btn btn-outline-success mb-3 mt-3"> <a class="text-dark" href="{{ url('impuestos/create') }}">
    Agregar Concepto
</a> </button> 


<div class="container">
    
    <h1>Conceptos</h1>
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>Concepto</th>
            <th>Porcentaje</th>
            <th>Opciones</th>

        </tr>
    </thead>
    <tbody>
        @foreach($taxes as $tax)
        <tr>
            <td>{{$tax->concept}}</td>
            <td>{{$tax->percentage}}</td>
           

            <td>
               <button class="btn btn-warning mb-2"> <a class="text-white" href="{{ url('impuestos/'.$tax->id.'/edit') }}">
                    Editar
                </a> </button> 
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{!! $taxes->links() !!}
</div>
</div>

@endsection
