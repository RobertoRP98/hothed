@extends('layouts.app')
@section('editcondition')
<div class="container">
    <br>
    <form action="{{ url('/almacen-herramientas/' . $toolwarehouse->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{method_field('PATCH')}}    
 <H1>Editar Herramienta</H1>
    @include('toolwarehouse.form',['modo'=>'Editar'])
  </form>
</div>
</div>

@endsection