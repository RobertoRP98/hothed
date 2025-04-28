@extends('layouts.app')
@section('documents')
<div class="container">
    <br>
<form action="{{url(('/puestos-trabajo'))}}" method="post" enctype="multipart/form-data">
    @csrf
 <H1>Crear Puesto de Trabajo</H1>
    @include('workstation.form', ['modo'=>'Crear'])
  </form>
</div>
@endsection