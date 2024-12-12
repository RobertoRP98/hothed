@extends('layouts.app')
@section('createcondition')
<div class="container">
    <br>
<form action="{{url(('/impuestos'))}}" method="post" enctype="multipart/form-data">
    @csrf
 <H1>Agregar Impuesto</H1>
    @include('tax.form', ['modo'=>'Crear'])
  </form>
</div>
@endsection