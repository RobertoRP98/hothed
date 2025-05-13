@extends('layouts.app')
@section('documents')
<div class="container">
    <br>
    <form action="{{ url('/puestos-trabajo/' . $workstation->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{method_field('PATCH')}}    
 <H1>Editar Puesto de Trabajo</H1>
    @include('modulo-documentos.workstation.form',['modo'=>'Editar'])
  </form>
</div>
@endsection