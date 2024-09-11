@extends('layouts.app')
@section('createstatus')
<div class="container">
    <br>
<form action="{{url(('/status'))}}" method="post" enctype="multipart/form-data">
    @csrf
 <H1>Agregar un Status</H1>
    @include('status.form', ['modo'=>'Crear'])
  </form>
</div>
@endsection