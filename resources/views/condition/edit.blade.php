@extends('layouts.app')
@section('editcondition')
<div class="container">
    <br>
    <form action="{{ url('/condiciones/' . $condition->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{method_field('PATCH')}}    
 <H1>Editar Condición</H1>
    @include('condition.form',['modo'=>'Editar'])
  </form>
</div>
@endsection