@extends('layouts.app')
@section('createstatus')
<div class="container">
    <br>
<form action="{{url(('/pozos'))}}" method="post" enctype="multipart/form-data">
    @csrf
 <H1>Agregar un Pozo</H1>
    @include('welloil.form', ['modo'=>'Crear'])
  </form>
</div>
@endsection