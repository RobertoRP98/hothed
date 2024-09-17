@extends('layouts.app')
@section('indexclient')

<div class="container">
 @if(Session::has('message'))
 {{Session::get('message')}}
 @endif   

<button type="button" class="btn btn-outline-success mb-3 mt-3"> <a class="text-dark" href="{{ url('tiposmantenimiento/create') }}">
    Agregar Tipo de Mantenimiento
</a> </button> 
<div class="container">
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>ID</th>
            <th>Tipo de mantenimiento</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($typemaint as $maint)
        <tr>
            <td>{{$maint->id}}</td>
            <td>{{$maint->maintenance}}</td>
            <td>
               <button class="btn btn-warning mb-2"> <a class="text-white" href="{{ url('tiposmantenimiento/'.$maint->id.'/edit') }}">
                    Editar
                </a> </button> 
            <!-- <form action="{{url('tiposmantenimiento/'.$maint->id)}}" method="post" class="d-inline">
                    @csrf
                    {{ method_field('DELETE') }}
                    <input type="submit" onclick="return confirm('¿Deseas borrar el registro?')"
                     value="Borrar">
                </form>  -->
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{!! $typemaint->links() !!}
</div>
</div>

@endsection
