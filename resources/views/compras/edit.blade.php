@extends('layouts.app')
@section('editsupplier')
<div class="container">
    <br>
    <form action="{{ url('/compras/' . $compra->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{method_field('PATCH')}}    
 <H1>Editar Orden de Compra</H1>
    @include('compras.form',['modo'=>'Editar'])
  </form>
</div>
@endsection