@extends('layouts.app')
@section('editclient')
<div class="container">
    <br>
    <form action="{{ url('/tiposmantenimiento/' . $typemaint->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{method_field('PATCH')}}    
 <H1>Editar Tipo de Mantenimiento</H1>
    @include('typemaint.form',['modo'=>'Editar'])
  </form>
</div>
@endsection