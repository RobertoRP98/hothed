@extends('layouts.app')
@section('createtax')
<div class="container">
    <br>
<form action="{{url(('/productos'))}}" method="post" enctype="multipart/form-data">
    @csrf
 <H1>Crear Producto</H1>
    @include('product.form', ['modo'=>'Crear'])
  </form>
</div>
@endsection