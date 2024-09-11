@extends('layouts.app')
@section('editclient')
<div class="container">
    <br>
    <form action="{{ url('/clientes/' . $client->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{method_field('PATCH')}}    
 <H1>Editar Empresa</H1>
    @include('client.form',['modo'=>'Editar'])
  </form>
</div>
@endsection