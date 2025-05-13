@extends('layouts.app')
@section('documents')
<div class="container">
    <br>
    <form action="{{ url('/users-sgi/' . $user->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{method_field('PATCH')}}    
 <H1>Editar Usuario</H1>
    @include('modulo-documentos.users-sgi.form',['modo'=>'Editar'])
  </form>
</div>
@endsection