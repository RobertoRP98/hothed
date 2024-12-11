@extends('layouts.app')
@section('edittax')
<div class="container">
    <br>
    <form action="{{ url('/impuestos/' . $tax->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{method_field('PATCH')}}    
 <H1>Editar Concepto</H1>
    @include('tax.form',['modo'=>'Editar'])
  </form>
</div>
@endsection