@extends('layouts.app')
@section('indexcondition')

<div class="container">
 @if(Session::has('message'))
 {{Session::get('message')}}
 @endif   

<button type="button" class="btn btn-outline-success mb-3 mt-3"> 
    <a class="text-dark" href="{{ url('almacenherramientas/') }}">
    Almacen de Herramientas
</a> </button> 
<div class="container">
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>ID</th>
            <th>HERRAMIENTA</th>
            <th>CAMPO CAMBIADO</th>
            <th>VALOR ANTERIOR</th>
            <th>VALOR NUEVO</th>
            <th>CAMBIADO POR </th>
            <th>FECHA MODIFICACIÓN </th>
        </tr>
    </thead>
    <tbody>
        @foreach( $histories as $history)
        <tr>
            <td>{{ $history->id }}</td>
            <td>{{ $history->toolwarehouse->description}}</td>
            <td>{{ $history->field }}</td>
            <td>{{ $history->old_value }}</td>
            <td>{{ $history->new_value }}</td>
            <td>{{ $history->user->name }}</td>
            <td>{{ $history->updated_at }}</td>
                    </tr>
        @endforeach
    </tbody>
</table>
{!! $histories->links() !!}
</div>
</div>

@endsection
