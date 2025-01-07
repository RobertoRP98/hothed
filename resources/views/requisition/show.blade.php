@extends('layouts.app')
@section('editsupplier')
<div class="container">
    <br>
    <form action="{{ url('/requisiciones/' . $requisition->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{method_field('GET')}}
        
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
      <div class="col-md-12">
        <h1>Ver requisición con numero identificador {{$requisition->id}}</h1>
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
 <view-requisition :initial-data="{{ json_encode($initialData) }}"  :default-request-date="'{{ $today }}'"></view-requisition>

</div>
    </form>
</div>
@endsection
