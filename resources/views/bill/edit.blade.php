@extends('layouts.app')
@section('editclient')
<div class="container">
    <br>
    <form action="{{ route('facturas.update', [$company->id, $bill->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{method_field('PATCH')}}    
 <H1>Editar Factura</H1>
    @include('bill.form',['modo'=>'Editar'])
  </form>
</div>
@endsection