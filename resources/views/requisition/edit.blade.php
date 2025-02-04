@extends('layouts.app')
@section('editsupplier')
<div class="container">
    <br>
    <form action="{{ url('/requisiciones/' . $requisition->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{method_field('PATCH')}}   
        
        <div class="row align-items-center">
          <div class="mb-3">
            <button type="button" class="btn btn-warning btn-block">
              @php
              $roleRedirects = [
                  'Developer' => '/requisiciones',
                  'RespCompras' => '/requisiciones',
                  // Empleados solicitantes
                  'Auxconta' => '/mis-requisiciones',
                  'Auxalmacen' => '/mis-requisiciones',
                  'Auxopeventas' => '/mis-requisiciones',
                  'Coordrh' => '/mis-requisiciones',
                  'Auxcontratos' => '/mis-requisiciones',
                  'Mcfly' => '/mis-requisiciones',

                  // Aprobadores
                  'Coordconta' => '/requisiciones-contabilidad',
                  'Coordalm' => '/requisiciones-almacen',
                  'Subgerope' => '/requisiciones-subope',
                  'Gerope' => '/requisiciones-gerope',
                  'Respsgi' => '/requisiciones-sgi',
                  'Diradmin' => '/requisiciones-administracion',
                  'Dirope' => '/requisiciones-dirope',
                  'Coordcontratos' => '/requisiciones-contratos',
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
            <h1>Editar la requisición número {{$requisition->id}}</h1>
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

 <meta name="user-id" content="{{ auth()->id() }}">

<!-- Tercera fila -->
<div id="app">
  <edit-requisition :initial-data="{{ json_encode($initialData) }}"  :default-request-date="'{{ $today }}'"></edit-requisition>

</div>


  </form>
</div>
@endsection