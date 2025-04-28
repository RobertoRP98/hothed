@extends('layouts.app')
@section('indexcondition')

<div class="container">
 @if(Session::has('message'))
 {{Session::get('message')}}
 @endif   


 <button type="button" class="btn btn-outline-success mb-3 mt-3 m-2"> <a class="text-dark" href="{{ url('/usuarios-sgi') }}">
    Regresar
</a> </button> 

<button type="button" class="btn btn-outline-success mb-3 mt-3"> <a class="text-dark" href="{{ url('puestos-trabajo/create') }}">
    Agregar Puesto de Trabajo
</a> </button> 


<div class="container">
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>ID</th>
            <th>PUESTO</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($workstations as $workstation)
        <tr>
            <td>{{ $workstation->id }}</td>
            <td>{{ $workstation->name }}</td>
            <td>
               <button class="btn btn-warning mb-2"> <a class="text-white" href="{{ url('puestos-trabajo/'.$workstation->id.'/edit') }}">
                    Editar
                </a> </button> 
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{!! $workstations->links() !!}
</div>
</div>

@endsection
