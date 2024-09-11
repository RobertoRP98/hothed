@extends('layouts.app')
@section('indexclient')

<div class="container">
 @if(Session::has('message'))
 {{Session::get('message')}}
 @endif   

<button type="button" class="btn btn-outline-success mb-3 mt-3"> <a class="text-dark" href="{{ url('clientes/create') }}">
    Agregar Cliente
</a> </button> 
<div class="container">
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Opciones</th>

        </tr>
    </thead>
    <tbody>
        @foreach($Clients as $Client)
        <tr>
            <td>{{$Client->id}}</td>
            <td>{{$Client->name}}</td>
            <td>
               <button class="btn btn-warning mb-2"> <a class="text-white" href="{{ url('clientes/'.$Client->id.'/edit') }}">
                    Editar
                </a> </button> 
            <!-- <form action="{{url('clientes/'.$Client->id)}}" method="post" class="d-inline">
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
{!! $Clients->links() !!}
</div>
</div>

@endsection
