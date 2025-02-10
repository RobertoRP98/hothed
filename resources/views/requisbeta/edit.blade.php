@extends('layouts.app')
@section('editsupplier')
<div class="container">
    <br>
    <form action="{{ url('/requisiciones-beta/' . $requi->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{method_field('PATCH')}}    
 <H1>Editar Requisición</H1>
    @include('requisbeta.form',['modo'=>'Editar'])
  </form>
</div>
@endsection