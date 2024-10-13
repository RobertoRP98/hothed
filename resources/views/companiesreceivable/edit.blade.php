@extends('layouts.app')
@section('editclient')
<div class="container">
    <br>
    <form action="{{ url('/empresas/' . $company->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{method_field('PATCH')}}    
 <H1>Editar Empresa</H1>
    @include('companiesreceivable.form',['modo'=>'Editar'])
  </form>
</div>
@endsection