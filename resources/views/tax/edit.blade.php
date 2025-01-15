@extends('layouts.app')
@section('editcondition')
<div class="container">
    <br>
    <form action="{{ url('/impuestos/' . $tax->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{method_field('PATCH')}}    
 <H1>Editar Impuesto</H1>
    @include('tax.form',['modo'=>'Editar'])
  </form>
</div>
@endsection