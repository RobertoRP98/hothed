@extends('layouts.app')
@section('documents')
<div class="container">
    <br>
<form action="{{url(('/areas-sgi'))}}" method="post" enctype="multipart/form-data">
    @csrf
 <H1>Crear Area de Trabajo</H1>
    @include('areas-sgi.form', ['modo'=>'Crear'])
  </form>
</div>
@endsection