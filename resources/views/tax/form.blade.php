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
      <input type="text" id="name" name="name" value="{{ isset($tax) ? $tax->name : '' }}" class="form-control" />
      <label class="form-label" for="Porcentaje">Concepto</label>
     </div>
   </div>
 </div>

 <div class="row mb-4 col-md-3">
  <div class="col">
    <div data-mdb-input-init class="form-outline">
     <input type="number" step="0.01" id="percent" name="percent" value="{{ isset($tax) ? $tax->percent : '' }}" class="form-control" placeholder="0.16 = IVA "/>
     <label class="form-label" for="Porcentaje">Porcentaje</label>
    </div>
  </div>
</div>

<br>
 <!-- Submit button -->
 <div class="row mb-4 col-md-6">

 <button type="submit" class="btn btn-primary btn-block col-md-3 m-1">{{$modo}} Concepto</button>
 
 <button type="button" class="btn btn-warning btn-block col-md-3 m-1"> <a class="text-white" href="{{ url('impuestos/') }}">
    Regresar
</a> </button> 

 </div>