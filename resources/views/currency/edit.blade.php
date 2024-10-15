@extends('layouts.app')
@section('editcondition')
<div class="container">
    <br>
    <form action="{{ url('/divisas/' . $currency->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{method_field('PATCH')}}    
 <H1>Editar Divisa</H1>
    @include('currency.form',['modo'=>'Editar'])
  </form>
</div>
@endsection