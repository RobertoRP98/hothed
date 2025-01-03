@extends('layouts.app')
@section('editsupplier')
<div class="container">
    <br>
    <form action="{{ url('/requisiciones/' . $requisition->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{method_field('PATCH')}}    
 <H1>Editar Producto</H1>

 <!-- 2 column grid layout with text inputs for the first and last names -->
 @if ($errors->any())
 <div class="alert alert-danger" role="alert">
   <ul>
     @foreach ($errors->all() as $error)
     <li>{{ $error }}</li>
     @endforeach
   </ul>
 </div>
 @endif

 <meta name="user-id" content="{{ auth()->id() }}">

<!-- Tercera fila -->
<div id="app">
  <edit-requisition :initial-data="{{ json_encode($initialData) }}"  :default-request-date="'{{ $today }}'"></edit-requisition>

</div>


  </form>
</div>
@endsection