@extends('layouts.app')
@section('indexclient')

<div class="container">
 @if(Session::has('message'))
 {{Session::get('message')}}
 @endif   

 <h1>Empresas Privadas</h1>

 <button type="button" class="btn btn-outline-success mb-3 mt-3 m-2"> <a class="text-dark" href="{{ route('facturas.index') }}">
    Regresar
</a> </button> 

 <ul class="list-group">
     @foreach ($empresasPrivadas as $empresa)
         <li  class="list-group-item col-md-4">
             <a href="{{ route('empresas.show', $empresa->id) }}">{{ $empresa->name }}</a>
         </li>
     @endforeach
 </ul>

</div>
@endsection
