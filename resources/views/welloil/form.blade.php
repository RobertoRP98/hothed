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
 <div class="row mb-4">
   <div class="col">
     <div data-mdb-input-init class="form-outline">
      <input type="text" id="name" name="name" value="{{ isset($welloil) ? $welloil->name : '' }}" class="form-control" />
      <label class="form-label" for="condition">Nombre del Pozo</label>
     </div>
     <div data-mdb-input-init class="form-outline">
      <input type="text" id="located" name="located" value="{{ isset($welloil) ? $welloil->located : '' }}" class="form-control" />
      <label class="form-label" for="condition">Ubicación</label>
     </div>
   </div>
 </div>

 <!-- Submit button -->
 <button type="submit" class="btn btn-primary btn-block mb-4">{{$modo}} Pozo</button>

 <button type="button" class="btn btn-warning btn-block mb-4"> <a class="text-white" href="{{ url('pozos/') }}">
    Regresar
</a> </button> 