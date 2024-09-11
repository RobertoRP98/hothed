@extends('layouts.app')
@section('editstatus')
<div class="container">
    <br>
    <form action="{{ url('/pozos/' . $welloil->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{method_field('PATCH')}}    
 <H1>Editar Pozo</H1>
    @include('welloil.form',['modo'=>'Editar'])
  </form>
</div>
@endsection