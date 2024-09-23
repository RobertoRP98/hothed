@extends('layouts.app')
@section('createcondition')
<div class="container">
    <br>
<form action="{{url(('/subgrupos'))}}" method="post" enctype="multipart/form-data">
    @csrf
 <H1>Agregar Subgrupo</H1>
    @include('subgroup.form', ['modo'=>'Crear'])
  </form>
</div>
@endsection
