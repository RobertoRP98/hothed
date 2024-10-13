@extends('layouts.app')
@section('createclient')
<div class="container">
    <br>
<form action="{{url(('/facturas/' . $company->id))}}" method="post" enctype="multipart/form-data">
    @csrf
 <H1>Crear Factura</H1>
    @include('bill.form', ['modo'=>'Crear'])
  </form>
</div>
@endsection