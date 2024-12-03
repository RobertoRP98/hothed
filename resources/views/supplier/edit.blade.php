@extends('layouts.app')
@section('edittax')
<div class="container">
    <br>
    <form action="{{ url('/proveedores/' . $supplier->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{method_field('PATCH')}}    
 <H1>Editar Proveedor</H1>
    @include('supplier.form',['modo'=>'Editar'])
  </form>
</div>
@endsection