@extends('layouts.app')
@section('createcondition')
<div class="container">
    <br>
<form action="{{url(('/condiciones'))}}" method="post" enctype="multipart/form-data">
    @csrf
 <H1>Agregar Condición de la herramienta</H1>
    @include('condition.form', ['modo'=>'Crear'])
  </form>
</div>
@endsection