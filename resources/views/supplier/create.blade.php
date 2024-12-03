@extends('layouts.app')
@section('createtax')
<div class="container">
    <br>
<form action="{{url(('/proveedores'))}}" method="post" enctype="multipart/form-data">
    @csrf
 <H1>Crear Proveedor</H1>
    @include('supplier.form', ['modo'=>'Crear'])
  </form>
</div>
@endsection