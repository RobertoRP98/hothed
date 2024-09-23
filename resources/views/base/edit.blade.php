@extends('layouts.app')
@section('editcondition')
<div class="container">
    <br>
    <form action="{{ url('/bases/' . $base->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{method_field('PATCH')}}    
 <H1>Editar Base de operaciones</H1>
    @include('base.form',['modo'=>'Editar'])
  </form>
</div>
@endsection