@extends('layouts.app')
@section('createsupplier')
<div class="container">
    <br>
<form action="{{url(('/compras'))}}" method="post" enctype="multipart/form-data">
    @csrf
 <H1>Agregar Orden de Compra</H1>
    @include('compras.form', ['modo'=>'Crear'])
  </form>
</div>
@endsection