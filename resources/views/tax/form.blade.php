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
      <input type="text" id="concept" name="concept" value="{{ isset($tax) ? $tax->concept : '' }}" class="form-control text-uppercase"  placeholder="EJEMPLO IVA 16%" />
      <label class="form-label" for="concept">CONCEPTO</label>
     </div>
   </div>
 </div>

 <div class="row mb-4 col-md-3">
  <div class="col">
    <div data-mdb-input-init class="form-outline">
     <input type="number" step="0.01"  id="percentage" name="percentage" value="{{ isset($tax) ? $tax->percentage : 0 }}" class="form-control" />
     <label class="form-label" for="name">PORCENTAJE</label>
    </div>
  </div>
</div>

 <!-- Submit button -->
 <button type="submit" class="btn btn-primary btn-block mb-4 m-2">{{$modo}} Concepto</button>

 <button type="button" class="btn btn-warning btn-block mb-3"> <a class="text-white" href="{{ url('impuestos/') }}">
    Regresar
</a> </button> 