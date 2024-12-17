@extends('layouts.app')
@section('editsupplier')
<div class="container">
    <br>
    <form action="{{ url('/requisiciones/' . $requisicion->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{method_field('GET')}}    
 <H1>Ver Orden de Compra</H1>
    @include('compras.form',['modo'=>'Ver'])
  </form>
</div>
@endsection