@extends('layouts.app')
@section('editcondition')
<div class="container">
    <br>
    <form action="{{ url('/toolstatus/' . $toolstatus->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{method_field('PATCH')}}    
 <H1>Editar Status de herramienta</H1>
    @include('toolstatus.form',['modo'=>'Editar'])
  </form>
</div>
@endsection