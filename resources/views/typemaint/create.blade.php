@extends('layouts.app')
@section('createclient')
<div class="container">
    <br>
<form action="{{url(('/tiposmantenimiento'))}}" method="post" enctype="multipart/form-data">
    @csrf
 <H1>Crear Tipo de Mantenimiento</H1>
    @include('typemaint.form', ['modo'=>'Crear'])
  </form>
</div>
@endsection