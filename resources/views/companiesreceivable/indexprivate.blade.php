@extends('layouts.app')
@section('indexclient')

<div class="container">
 @if(Session::has('message'))
 {{Session::get('message')}}
 @endif   

 <h1>Empresas Privadas</h1>

 <ul class="list-group">
     @foreach ($empresasPrivadas as $empresa)
         <li  class="list-group-item col-md-4">
             <a href="{{ route('empresas.show', $empresa->id) }}">{{ $empresa->name }}</a>
         </li>
     @endforeach
 </ul>

</div>
@endsection
