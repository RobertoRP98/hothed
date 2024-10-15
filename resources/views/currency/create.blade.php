@extends('layouts.app')
@section('createcondition')
<div class="container">
    <br>
<form action="{{url(('/divisas'))}}" method="post" enctype="multipart/form-data">
    @csrf
 <H1>Agregar Divisas</H1>
    @include('currency.form', ['modo'=>'Crear'])
  </form>
</div>
@endsection