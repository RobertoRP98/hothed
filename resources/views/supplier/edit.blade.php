@extends('layouts.app')
@section('editcondition')
<div class="container">
    <br>
    <form action="{{ url('/proveedores/' . $supplier->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{method_field('PATCH')}}    
 <H1>Editar Proveedor TEST</H1>
    @include('supplier.form',['modo'=>'Editar'])
  </form>
</div>
@endsection