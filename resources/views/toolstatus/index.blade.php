@extends('layouts.app')
@section('indexcondition')

<div class="container">
 @if(Session::has('message'))
 {{Session::get('message')}}
 @endif   

 <div class="col-md-12">

    <a href="{{ url('/almacen-herramientas') }}" class="col-md-3 btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
        Almacen de Herramientas
    </a>

    <button type="button" class="btn btn-outline-success mb-3 mt-3"> <a class="text-dark" href="{{ url('toolstatus/create') }}">
        Agregar Status de herramientas
    </a> </button> 

</div>


<div class="container">
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>ID</th>
            <th>Status</th>
            <th>Opciones</th>

        </tr>
    </thead>
    <tbody>
        @foreach($toolstatus as $tool)
        <tr>
            <td>{{ $tool->id }}</td>
            <td>{{ $tool->status }}</td>
            <td>
               <button class="btn btn-warning mb-2"> <a class="text-white" href="{{ url('toolstatus/'.$tool->id.'/edit') }}">
                    Editar
                </a> </button> 
            <!-- <form action="{{url('toolstatus/'.$tool->id)}}" method="post" class="d-inline">
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
{!! $toolstatus->links() !!}
</div>
</div>

@endsection
