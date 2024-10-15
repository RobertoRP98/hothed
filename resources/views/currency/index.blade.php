@extends('layouts.app')
@section('indexcondition')

<div class="container">
 @if(Session::has('message'))
 {{Session::get('message')}}
 @endif   


 <button type="button" class="btn btn-outline-success mb-3 mt-3 m-2"> <a class="text-dark" href="{{ route('facturas.index') }}">
    Regresar
</a> </button> 

<button type="button" class="btn btn-outline-success mb-3 mt-3"> <a class="text-dark" href="{{ url('divisas/create') }}">
    Agregar Divisa
</a> </button> 


<div class="container">
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>ID</th>
            <th>Divisa</th>
            <th>Valor</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($currency as $curr)
        <tr>
            <td>{{ $curr->id }}</td>
            <td>{{ $curr->currency }}</td>
            <td>{{ $curr->rate }}</td>
            <td>
               <button class="btn btn-warning mb-2"> <a class="text-white" href="{{ url('divisas/'.$curr->id.'/edit') }}">
                    Editar
                </a> </button> 
            <!-- <form action="{{url('familias/'.$curr->id)}}" method="post" class="d-inline">
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
{!! $currency->links() !!}
</div>
</div>

@endsection
