@extends('layouts.app')
@section('editcondition')
<div class="container">
    <br>
    <form action="{{ url('/subgrupos/' . $subgroup->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{method_field('PATCH')}}    
 <H1>Editar Subgrupo</H1>
    @include('subgroup.form',['modo'=>'Editar'])
  </form>
</div>
@endsection