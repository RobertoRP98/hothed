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

<!-- Primera fila -->
<div class="row mb-4">

    <div class="col-md-6">
        <div class="form-outline">
            <input type="text" id="name" name="name" value="{{ old('name', isset($supplier) ? $supplier->name : '') }}" class="form-control text-uppercase" />
            <label class="form-label" for="name">NOMBRE</label>
        </div>
    </div>

    <div class="col-md-6">
      <div class="form-outline">
          <input type="text" id="rfc" name="rfc" minlength="12" maxlength="13" value="{{ old('rfc', isset($supplier) ? $supplier->rfc : '')}}" class="form-control text-uppercase" />
          <label class="form-label" for="rfc">RFC</label>
      </div>
  </div>

</div>

<!-- Segunda fila -->
<div class="row mb-4">  

  <div class="col-md-3">
    <div class="form-outline">
        <input type="text" id="number" name="number" minlength="10" maxlength="12" value="{{ old('number', isset($supplier) ? $supplier->number : '' )}}" class="form-control" />
        <label class="form-label" for="rumber">NUMERO DE CONTACTO</label>
    </div>
</div>

<div class="col-md-3">
  <div class="form-outline">
      <input type="email" id="email" name="email" value="{{ old('email', isset($supplier) ? $supplier->email : '') }}" class="form-control" />
      <label class="form-label" for="email">CORREO DE CONTACTO</label>
  </div>
</div>

<div class="col-md-6">
  <div class="form-outline">
      <input type="text" id="address" name="address" value="{{ old('address',isset($supplier) ? $supplier->address : '')}}" class="form-control text-uppercase" />
      <label class="form-label" for="address">DIRECCIÓN</label>
  </div>
</div>

</div>

<!-- Tercera fila -->
<div class="row mb-4">

  <div class="col-md-3">
    <div class="form-outline">
        <select id="critic" name="critic" class="form-select">
            <option value="0" {{ old('critic', isset($supplier) ? $supplier->critic : 0) == 0 ? 'selected' : '' }}>NO</option>
            <option value="1" {{ old('critic', isset($supplier) ? $supplier->critic : 0) == 1 ? 'selected' : '' }}>SI</option>
        </select>
        <label class="form-label" for="critic">¿PROVEEDOR CRITICO?</label>
    </div>
</div>

<div class="col-md-3">
    <div class="form-outline">
        <select class="form-select" name="currency" id="currency">
            <option value="MXN" {{ old('currency', isset($supplier) ? $supplier->currency : '') == 'MXN' ? 'selected' : '' }}>MXN</option>
            <option value="USD" {{ old('currency', isset($supplier) ? $supplier->currency : '') == 'USD' ? 'selected' : '' }}>USD</option>
            <option value="MIXTO" {{ old('currency', isset($supplier) ? $supplier->currency : '') == 'MIXTO' ? 'selected' : '' }}>MIXTO</option>
        </select>
        <label class="form-label" for="currency">DIVISA</label>
    </div>
</div>

<div class="col-md-3">
    <div class="form-outline">
        <input type="number" id="credit_days" name="credit_days" value="{{ old('credit_days', isset($supplier) ? $supplier->credit_days : 0) }}" class="form-control" />
        <label class="form-label" for="credit_days">DIAS DE CREDITO</label>
    </div>
</div>

<div class="col-md-3">
    <div class="form-outline">
        <select id="unique" name="unique" class="form-select">
            <option value="0" {{ old('unique', isset($supplier) ? $supplier->unique : 0) == 0 ? 'selected' : '' }}>NO</option>
            <option value="1" {{ old('unique', isset($supplier) ? $supplier->unique : 0) == 1 ? 'selected' : '' }}>SI</option>
        </select>
        <label class="form-label" for="unique">¿PROVEEDOR UNICO?</label>
    </div>
</div>

</div>

<br>
 <!-- Submit button -->
 <div class="row mb-4 col-md-6">

 <button type="submit" class="btn btn-primary btn-block col-md-3 m-1">{{$modo}} Proveedor</button>
 
 <button type="button" class="btn btn-warning btn-block col-md-3 m-1"> <a class="text-white" href="{{ url('proveedores/') }}">
    Regresar
</a> </button> 

 </div>