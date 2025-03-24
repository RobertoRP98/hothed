@extends('layouts.app')
@section('editsupplier')

@push('css')
<!-- CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
@endpush
<div class="container">
    <br>
    <form @submit.prevent>
        @csrf
        {{method_field('PATCH')}}   
        
        <div class="row align-items-center">
          <div class="mb-3">
            <button type="button" class="btn btn-warning btn-block">
              
              @php
          $roleRedirects = [
              'Developer' => '/ordenes-compra/autorizacion/pendientes',
              'RespCompras' => '/ordenes-compra/autorizacion/pendientes',
              'Diradmin' => '/ordenes-compra/autorizacion/pendientes',
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
            <h1>AUTORIZAR LA ORDEN  {{$order->id}} VINCULADA A LA REQUISICIÓN {{$order->requisition->id}}</h1>
          </div>
         
        </div>

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


<!-- Tercera fila -->
<div id="app">
  <edit-autorizacion :initial-data='@json($initialData)'  :default-request-date="'{{ $today }}'"></edit-autorizacion>

</div>


  </form>
</div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

@endpush