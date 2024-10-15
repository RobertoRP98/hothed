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
      <input type="text" id="currency" name="currency" value="{{ isset($currency) ? $currency->currency : '' }}" class="form-control text-uppercase" maxlength="3" placeholder="USD, EUR, CAT, ETC" />
      <label class="form-label" for="name">Nombre de la divisa</label>
     </div>
   </div>
 </div>

 <div class="row mb-4 col-md-3">
  <div class="col">
    <div data-mdb-input-init class="form-outline">
     <input type="number" step="0.01"  id="rate" name="rate" value="{{ isset($currency) ? $currency->rate : '' }}" class="form-control" />
     <label class="form-label" for="name">Valor de la divisa</label>
    </div>
  </div>
</div>

 <!-- Submit button -->
 <button type="submit" class="btn btn-primary btn-block mb-4 m-2">{{$modo}} Divisa</button>

 <button type="button" class="btn btn-warning btn-block mb-3"> <a class="text-white" href="{{ url('divisas/') }}">
    Regresar
</a> </button> 