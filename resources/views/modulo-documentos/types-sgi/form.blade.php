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
      <input type="text" id="name" name="name" value="{{ isset($type) ? $type->name : '' }}" class="form-control " 
       placeholder="INSTRUCTIVO" />
      <label class="form-label" for="name">TIPO DE DOCUMENTO</label>
     </div>
   </div>
 </div>


 <!-- Submit button -->
 <button type="submit" class="btn btn-primary btn-block mb-4 m-2">{{$modo}} Tipo de Documento</button>

 <button type="button" class="btn btn-warning btn-block mb-3"> <a class="text-white" href="{{ url('/tipos-documentos') }}">
    Regresar
</a> </button> 