@extends('layouts.app')
@section('documents')
<div class="container">
    <br>
    <form action="{{ url('/areas-sgi/' . $area->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{method_field('PATCH')}}    
 <H1>Editar Area de Trabajo</H1>
    @include('modulo-documentos.areas-sgi.form',['modo'=>'Editar'])
  </form>
</div>
@endsection