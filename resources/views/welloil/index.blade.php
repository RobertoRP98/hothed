@extends('layouts.app')
@section('indexcondition')

<div class="container">
 @if(Session::has('message'))
 {{Session::get('message')}}
 @endif   

<button type="button" class="btn btn-outline-success mb-3 mt-3"> 
    <a class="text-dark" href="{{ url('pozos/create') }}">
    Agregar Pozos
</a> </button> 
<div class="container">
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>ID</th>
            <th>Pozos</th>
            <th>Ubicación</th>
            <th>Opciones</th>

        </tr>
    </thead>
    <tbody>
        @foreach($Welloil as $well)
        <tr>
            <td>{{ $well->id }}</td>
            <td>{{ $well->name }}</td>
            <td>{{ $well->located }}</td>
            <td>
               <button class="btn btn-warning mb-2"> <a class="text-white" href="{{ url('pozos/'.$well->id.'/edit') }}">
                    Editar
                </a> </button> 
            <!-- <form action="{{url('pozos/'.$well->id)}}" method="post" class="d-inline">
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
{!! $Welloil->links() !!}
</div>
</div>

@endsection
