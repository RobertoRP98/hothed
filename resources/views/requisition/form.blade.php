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
  <compras-component :initial-data="{{ json_encode($initialData) }}" :default-request-date="'{{ $today }}'"></compras-component>

</div>



  <button type="button" class="btn btn-warning btn-block col-md-3 m-1">
    <a class="text-white" href="{{ url('requisiciones/') }}">
      Regresar
    </a>
  </button>
</div>
