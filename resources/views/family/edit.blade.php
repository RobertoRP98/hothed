@extends('layouts.app')
@section('editcondition')
<div class="container">
    <br>
    <form action="{{ url('/familias/' . $family->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{method_field('PATCH')}}    
 <H1>Editar Familia de herramientas</H1>
    @include('family.form',['modo'=>'Editar'])
  </form>
</div>
@endsection