@extends('layouts.app')
@section('editstatus')
<div class="container">
    <br>
    <form action="{{ url('/status/' . $status->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{method_field('PATCH')}}    
 <H1>Editar Status</H1>
    @include('status.form',['modo'=>'Editar'])
  </form>
</div>
@endsection