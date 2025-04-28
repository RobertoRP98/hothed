@extends('layouts.app')
@section('documents')
<div class="container">
    <br>
<form action="{{url(('/users-sgi'))}}" method="post" enctype="multipart/form-data">
    @csrf
 <H1>Crear Usuario</H1>
    @include('users-sgi.form', ['modo'=>'Crear'])
  </form>
</div>
@endsection