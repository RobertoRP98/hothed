@extends('layouts.app')
@section('createcondition')
<div class="container">
    <br>
<form action="{{url(('/toolstatus'))}}" method="post" enctype="multipart/form-data">
    @csrf
 <H1>Agregar Status de herramienta</H1>
    @include('toolstatus.form', ['modo'=>'Crear'])
  </form>
</div>
@endsection