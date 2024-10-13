@extends('layouts.app')
@section('indexclient')

<div class="container">
 @if(Session::has('message'))
 {{Session::get('message')}}
 @endif   

<button type="button" class="btn btn-outline-success mb-3 mt-3"> <a class="text-dark" href="{{ url('empresas/create') }}">
    Agregar Empresa
</a> </button> 
<div class="container">
    
    <h1>Empresas</h1>
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>Cliente</th>
            <th>Tipo</th>
            <th>Dias de credito</th>
            <th>Opciones</th>

        </tr>
    </thead>
    <tbody>
        @foreach($Companies as $Company)
        <tr>
            <td>{{$Company->name}}</td>
            <td>{{$Company->type}}</td>
            <td>{{$Company->creditdays}}</td>
            <td>
               <button class="btn btn-warning mb-2"> <a class="text-white" href="{{ url('empresas/'.$Company->id.'/edit') }}">
                    Editar
                </a> </button> 
            <!-- <form action="{{url('empresas/'.$Company->id)}}" method="post" class="d-inline">
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
{!! $Companies->links() !!}
</div>
</div>

@endsection
