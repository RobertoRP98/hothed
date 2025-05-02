@extends('layouts.app')
@section('documents')
<div class="container">
    <br>
    <form action="{{ url('/categorias-documentos/' . $category->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{method_field('PATCH')}}    
 <H1>Editar Categoria para Documentos</H1>
    @include('categories-sgi.form',['modo'=>'Editar'])
  </form>
</div>
@endsection