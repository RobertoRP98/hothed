@extends('layouts.app')
@section('createstatus')
<div class="container">
    <br>
<form action="{{url(('/herramientasrenta'))}}" method="post" enctype="multipart/form-data">
    @csrf
 <H1>Agregar una Herramienta</H1>
    @include('toolrent.form', ['modo'=>'Crear'])
  </form>
</div>
@endsection