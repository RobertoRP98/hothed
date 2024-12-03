@extends('layouts.app')
@section('edittax')
<div class="container">
    <br>
    <form action="{{ url('/productos/' . $product->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{method_field('PATCH')}}    
 <H1>Editar Producto</H1>
    @include('product.form',['modo'=>'Editar'])
  </form>
</div>
@endsection