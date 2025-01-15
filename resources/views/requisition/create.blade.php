@extends('layouts.app')
@section('createsupplier')
<div class="container">
<form action="{{url(('/requisiciones'))}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row align-items-center">
      <div class="mb-3">
        <button type="button" class="btn btn-warning btn-block">
          @if(auth()->user()->hasRole('Cobranza2'))
          <a class="text-white" href="{{ url('requisiciones-ope') }}">
              REGRESAR
          </a>
      @elseif(auth()->user()->hasRole('Cobranza'))
          <a class="text-white" href="{{ url('requisiciones-adm') }}">
              REGRESAR
          </a>
      @else
          <a class="text-white" href="{{ url('requisiciones/') }}">
              REGRESAR
          </a>
      @endif
        </button>
      </div>
      <div class="col-md-6">
        <h1>Agregar Requisición</h1>
      </div>
     
    </div>
    

<br>

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
  <create-requisition :initial-data="{{ json_encode($initialData) }}"  :default-request-date="'{{ $today }}'"></create-requisition>

</div>

  </form>
</div>
@endsection