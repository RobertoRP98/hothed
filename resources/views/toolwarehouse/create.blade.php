@extends('layouts.app')
@section('createcondition')
<div class="container">
    <br>
<form action="{{url(('/almacenherramientas'))}}" method="post" enctype="multipart/form-data">
    @csrf
 <H1>Agregar Herramienta</H1>
    @include('toolwarehouse.form', ['modo'=>'Crear'])
  </form>
</div>
@endsection