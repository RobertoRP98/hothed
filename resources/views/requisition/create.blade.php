@extends('layouts.app')
@section('createsupplier')
<div class="container">
    <br>
<form action="{{url(('/requisiciones'))}}" method="post" enctype="multipart/form-data">
    @csrf
 <H1>Agregar Requisición</H1>
    @include('requisition.form', ['modo'=>'Crear'])
  </form>
</div>
@endsection