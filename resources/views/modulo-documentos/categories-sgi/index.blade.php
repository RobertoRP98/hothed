@extends('layouts.app')
@section('indexcondition')

<div class="container">
 @if(Session::has('message'))
 {{Session::get('message')}}
 @endif   


 <button type="button" class="btn btn-outline-success mb-3 mt-3 m-2"> <a class="text-dark" href="{{ url('/documentos-sgi') }}">
    Regresar
</a> </button> 

<button type="button" class="btn btn-outline-success mb-3 mt-3"> <a class="text-dark" href="{{ url('categorias-documentos/create') }}">
    Agregar Categoria para Documentos
</a> </button> 


<div class="container">
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>ID</th>
            <th>CATEGORIA</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>
               <button class="btn btn-warning mb-2"> <a class="text-white" href="{{ url('categorias-documentos/'.$category->id.'/edit') }}">
                    Editar
                </a> </button> 
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{!! $categories->links() !!}
</div>
</div>

@endsection
