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
      <input type="text" id="name" name="name" value="{{ isset($company) ? $company->name : '' }}" class="form-control text-uppercase" />
      <label class="form-label" for="nameclient">Nombre</label>
     </div>
   </div>
 </div>

 <div class="row mb-4 col-md-3">
  <div class="col">
    <div data-mdb-input-init class="form-outline">
     <input type="number" id="creditdays" name="creditdays" value="{{ isset($company) ? $company->creditdays : '' }}" class="form-control" />
     <label class="form-label" for="nameclient">Dias de credito</label>
    </div>
  </div>
</div>

 <div class="row mb-4 col-md-3">
  <div class="col">
    <div data-mdb-input-init class="form-outline">
 <select class="form-select" name="type" id="type">
  <option value="Privada" {{ isset($company) && $company->type == 'Privada' ? 'selected' : '' }}>Privada</option>
  <option value="Pemex" {{ isset($company) && $company->type == 'Pemex' ? 'selected' : '' }}>Pemex</option>
</select>
<label class="form-label" for="critic">Tipo de Empresa</label>

    </div>
  </div>
 </div>

 <div class="row mb-4 col-md-3">
  <div class="col">
    <div data-mdb-input-init class="form-outline">
 <select class="form-select" name="currency" id="currency">
  <option value="USD" {{ isset($currency) && $currency->currency == 'USD' ? 'selected' : '' }}>USD</option>
  <option value="MXN" {{ isset($company) && $company->currency == 'MXN' ? 'selected' : '' }}>MXN</option>
  <option value="MIXTA" {{ isset($company) && $company->currency == 'MIXTA' ? 'selected' : '' }}>MIXTA</option>
</select>
<label class="form-label" for="critic">Tipo de Divisa</label>

    </div>
  </div>
 </div>

<br>
 <!-- Submit button -->
 <div class="row mb-4 col-md-6">

 <button type="submit" class="btn btn-primary btn-block col-md-3 m-1">{{$modo}} cliente</button>
 
 <button type="button" class="btn btn-warning btn-block col-md-3 m-1"> <a class="text-white" href="{{ url('empresas/') }}">
    Regresar
</a> </button> 

 </div>