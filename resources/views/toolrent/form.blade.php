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
      <input type="text" id="serienumber" name="serienumber" value="{{ isset($toolrent) ? $toolrent->serienumber : '' }}" class="form-control" />
      <label class="form-label" for="serienumber">Numero de serie</label>
     </div>
     <div data-mdb-input-init class="form-outline">
      <input type="text" id="description" name="description" value="{{ isset($toolrent) ? $toolrent->description : '' }}" class="form-control" />
      <label class="form-label" for="serienumber">Descripcion</label>
     </div>
   </div>
 </div>

 <!-- Submit button -->
 <button type="submit" class="btn btn-primary btn-block mb-4">{{$modo}} Herramienta</button>

 <button type="button" class="btn btn-warning btn-block mb-4"> <a class="text-white" href="{{ url('herramientasrenta/') }}">
    Regresar
</a> </button> 