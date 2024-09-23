@extends('layouts.app')
@section('createcondition')
<div class="container">
    <br>
<form action="{{url(('/familias'))}}" method="post" enctype="multipart/form-data">
    @csrf
 <H1>Agregar Familias de herramientas</H1>
    @include('family.form', ['modo'=>'Crear'])
  </form>
</div>
@endsection