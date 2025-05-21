@extends('layouts.app')
@section('indexcondition')

<div class="container">
 @if(Session::has('message'))
 {{Session::get('message')}}
 @endif   


 <button type="button" class="btn btn-outline-success mb-3 mt-3 m-2"> <a class="text-dark" href="{{ url('/documentacion-sgi') }}">
    Regresar
</a> </button> 

<button type="button" class="btn btn-outline-success mb-3 mt-3"> <a class="text-dark" href="{{ url('tipos-documentos/create') }}">
    Agregar Tipo para Documentos
</a> </button> 


<div class="container">
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>ID</th>
            <th>TIPO</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($types as $type)
        <tr>
            <td>{{ $type->id }}</td>
            <td>{{ $type->name }}</td>
            <td>
               <button class="btn btn-warning mb-2"> <a class="text-white" href="{{ url('tipos-documentos/'.$type->id.'/edit') }}">
                    Editar
                </a> </button> 
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{!! $types->links() !!}
</div>
</div>

@endsection
