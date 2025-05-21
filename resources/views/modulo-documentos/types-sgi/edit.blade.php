@extends('layouts.app')
@section('documents')
<div class="container">
    <br>
    <form action="{{ url('/tipos-documentos/' . $type->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{method_field('PATCH')}}    
 <H1>Editar Tipo para Documentos</H1>
    @include('modulo-documentos.types-sgi.form',['modo'=>'Editar'])
  </form>
</div>
@endsection