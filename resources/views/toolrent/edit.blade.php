@extends('layouts.app')
@section('editstatus')
<div class="container">
    <br>
    <form action="{{ url('/herramientasrenta/' . $toolrent->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{method_field('PATCH')}}    
 <H1>Editar Herramienta</H1>
    @include('toolrent.form',['modo'=>'Editar'])
  </form>
</div>
@endsection