@extends('layouts.app')
@section('documents')
<div class="container">
    <br>
<form action="{{url(('/documentacion-sgi'))}}" method="post" enctype="multipart/form-data">
    @csrf
 <H1>Crear Documento</H1>
    @include('modulo-documentos.documents.form', ['modo'=>'Crear'])
  </form>
</div>
@endsection