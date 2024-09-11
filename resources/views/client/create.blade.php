@extends('layouts.app')
@section('createclient')
<div class="container">
    <br>
<form action="{{url(('/clientes'))}}" method="post" enctype="multipart/form-data">
    @csrf
 <H1>Crear Empresa</H1>
    @include('client.form', ['modo'=>'Crear'])
  </form>
</div>
@endsection