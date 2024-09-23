@extends('layouts.app')
@section('createcondition')
<div class="container">
    <br>
<form action="{{url(('/bases'))}}" method="post" enctype="multipart/form-data">
    @csrf
 <H1>Agregar Base de operaciones</H1>
    @include('base.form', ['modo'=>'Crear'])
  </form>
</div>
@endsection