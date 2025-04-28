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


 <br>
 <div class="row mb-4 col-md-3">
   <div class="col">
     <div data-mdb-input-init class="form-outline">
      <input type="text" id="name" name="name" value="{{ isset($workstation) ? $workstation->name : '' }}" class="form-control "  placeholder="AUXILIAR DE ALMACEN" />
      <label class="form-label" for="concept">PUESTO DE TRABAJO</label>
     </div>
   </div>
 </div>


 <!-- Submit button -->
 <button type="submit" class="btn btn-primary btn-block mb-4 m-2">{{$modo}} Puesto de Trabajo</button>

 <button type="button" class="btn btn-warning btn-block mb-3"> <a class="text-white" href="{{ url('/puestos-trabajo') }}">
    Regresar
</a> </button> 