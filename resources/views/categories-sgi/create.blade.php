@extends('layouts.app')
@section('documents')
<div class="container">
    <br>
<form action="{{url(('/categorias-documentos'))}}" method="post" enctype="multipart/form-data">
    @csrf
 <H1>Crear Categoria para Documentos</H1>
    @include('categories-sgi.form', ['modo'=>'Crear'])
  </form>
</div>
@endsection