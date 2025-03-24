@extends('layouts.app')
@section('createsupplier')
<div class="container">
  
<form @submit.prevent>
    @csrf
    <div class="row align-items-center">
      <div class="mb-3">
        
        <button type="button" class="btn btn-warning btn-block">
          @php
          $roleRedirects = [
              'Developer' => '/ordenes-compra',
              'RespCompras' => '/ordenes-compra',
              'Diradmin' => '/ordenes-compra',
          ];
          
          // Obtener el primer rol del usuario que tenga una redirección definida
          $userRole = auth()->user()->roles->pluck('name')->intersect(array_keys($roleRedirects))->first();
          $redirectUrl = $userRole ? url($roleRedirects[$userRole]) : url('/');
      @endphp
  
      @if ($userRole)
          <a class="text-white" href="{{ $redirectUrl }}">
              REGRESAR
          </a>
      @endif
      </button>
      
      </div>
      <div class="col-md-12">
        <h1>Vincular Orden de Compra a la Requisición {{$requisicion->id}}</h1>
      </div>
     
    </div>
    


 @if ($errors->any())
 <div class="alert alert-danger" role="alert">
   <ul>
     @foreach ($errors->all() as $error)
     <li>{{ $error }}</li>
     @endforeach
   </ul>
 </div>
 @endif


<!-- Tercera fila -->
<div id="app">
    <create-compra :initial-data="{{ json_encode($initialData) }}"></create-compra>
</div>


  </form>
</div>



@endsection

