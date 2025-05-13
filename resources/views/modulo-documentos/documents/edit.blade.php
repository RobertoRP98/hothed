@extends('layouts.app')
@section('documents')
<div class="container">
    <br>
    <form action="{{ url('/documentacion-sgi/' . $document->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{method_field('PATCH')}}    
 <H1>Editar Documento</H1>
    @include('modulo-documentos.documents.form',['modo'=>'Editar'])
  </form>
</div>
@endsection