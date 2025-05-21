@extends('layouts.app')
@section('documents')
<div class="container">
    <br>
<form action="{{url(('/tipos-documentos'))}}" method="post" enctype="multipart/form-data">
    @csrf
 <H1>Crear Tipo para Documentos</H1>
    @include('modulo-documentos.types-sgi.form', ['modo'=>'Crear'])
  </form>
</div>
@endsection