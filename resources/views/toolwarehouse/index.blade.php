@extends('layouts.app')
@section('indexcondition')

<div class="container">
 @if(Session::has('message'))
 {{Session::get('message')}}
 @endif   

<button type="button" class="btn btn-outline-success mb-3 mt-3"> <a class="text-dark" href="{{ url('almacenherramientas/create') }}">
    Agregar Herramienta
</a> </button> 
<div class="container">
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>ID</th>
            <th>Familia</th>
            <th>Descripción</th>
            <th>N. Serie</th>
            <th>Base de Op.</th>
            <th>Status</th>
            <th>Comentario</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($toolwarehouse as $tool)
        <tr>
            <td>{{ $tool->id }}</td>
            <td>{{ $tool->family->name }}</td>
            <td>{{ $tool->description }}</td>
            <td>{{ $tool->serienum }}</td>
            <td>{{ $tool->base->name }}</td>
            <td>{{ $tool->toolstatus->status }}</td>
            <td>{{ $tool->comentary }}</td>
            <td>
               <button class="btn btn-warning mb-2"> <a class="text-white" href="{{ url('almacenherramientas/'.$tool->id.'/edit') }}">
                    Editar
                </a> </button> 
            <!-- <form action="{{url('herramientasalmacen/'.$tool->id)}}" method="post" class="d-inline">
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
{!! $toolwarehouse->links() !!}
</div>
</div>

@endsection
