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

    <div class="col-md-3">
        <div class="form-outline">
            <input type="text" id="internal_id" name="internal_id" value="{{ isset($product) ? $product->internal_id : '' }}" class="form-control text-uppercase" placeholder="ESTE IDENTIFICADOR ES UNICO"/>
            <label class="form-label" for="internal_id ">IDENTIFICADOR INTERNO</label>
        </div>
    </div>

    <div class="col-md-6">
      <div class="form-outline">
          <input type="text" id="description" name="description" value="{{ isset($product) ? $product->description : '' }}" class="form-control text-uppercase" placeholder="NOMBRE DEL PRODUCTO"/>
          <label class="form-label" for="internal_id ">DESCRIPCIÓN</label>
      </div>
  </div>

  <div class="col-md-3">
    <div class="form-outline">
        <input type="text" id="brand" name="brand" value="{{ isset($product) ? $product->brand : '' }}" class="form-control text-uppercase"/>
        <label class="form-label" for="internal_id ">MARCA DEL PRODUCTO</label>
    </div>
</div>
    

</div>

<!-- Segunda fila -->
<div class="row mb-4">  

  <div class="col-md-3">
    <div class="form-outline">
        <input type="number" id="quantity" name="quantity" value="{{ isset($supplier) ? $supplier->quantity : 0 }}" class="form-control" />
        <label class="form-label" for="quantity">CANTIDAD</label>
    </div>
  </div>


<div class="col-md-8">
  <div class="form-outline">
      <input type="text" id="address" name="address" value="{{isset($supplier) ? $supplier->address : ''}}" class="form-control" />
      <label class="form-label" for="address">DIRECCIÓN</label>
  </div>
</div>

</div>

<!-- Tercera fila -->
<div class="row mb-4">

  <div class="col-md-3">
    <div class="form-outline">
        <select id="critic" name="critic" class="form-select">
          <option value="0" {{ isset($supplier) && $supplier->critic ? 'selected' : '' }}>NO</option>
          <option value="1" {{ isset($supplier) && $supplier->critic ? 'selected' : '' }}>SI</option>
        </select>
        <label class="form-label" for="critic">¿PROVEEDOR CRITICO?</label>

    </div>
</div>

<div class="col-md-3">
  <div class="form-outline">
      <select class="form-select" name="currency" id="currency">
      <option value="MXN" {{isset($supplier) && $supplier->currency == 'MXN' ? 'selected':''}}>MXN</option>
      <option value="USD" {{isset($supplier) && $supplier->currency == 'USD' ? 'selected':''}}>USD</option>
      <option value="MIXTO" {{isset($supplier) && $supplier->currency == 'MIXTO' ? 'selected':''}}>MIXTO</option>
      </select>
      <label class="form-label" for="currency">DIVISA</label>
</div>   
</div>



<div class="col-md-3">
  <div class="form-outline">
      <select id="unique" name="unique" class="form-select">
        <option value="0" {{ isset($supplier) && $supplier->unique ? 'selected' : '' }}>NO</option>
        <option value="1" {{ isset($supplier) && $supplier->unique ? 'selected' : '' }}>SI</option>
      </select>
      <label class="form-label" for="critic">¿PROVEEDOR UNICO?</label>

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