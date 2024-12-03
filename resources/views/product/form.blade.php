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
            <input type="text" id="name" name="name" value="{{ isset($product) ? $product->name : '' }}" class="form-control" />
            <label class="form-label" for="name">NOMBRE DEL PRODUCTO</label>
        </div>
    </div>

    <div class="col-md-3">
      <div class="form-outline">
        <select class="form-select" name="udm" id="udm">
          <option value="Pieza" {{ isset($product) && $product->udm == 'Pieza' ? 'selected' : '' }}>PIEZA</option>
          <option value="Kilo" {{ isset($product) && $product->udm == 'Kilo' ? 'selected' : '' }}>KILO</option>
          <option value="Litro" {{ isset($product) && $product->udm == 'Litro' ? 'selected' : '' }}>LITRO</option>
          <option value="Galón" {{ isset($product) && $product->udm == 'Galón' ? 'selected' : '' }}>GALÓN</option>
          <option value="Garrafa" {{ isset($product) && $product->udm == 'Garrafa' ? 'selected' : '' }}>GARRAFA</option>
          <option value="Servicio" {{ isset($product) && $product->udm == 'Servicio' ? 'selected' : '' }}>SERVICIO</option>
        </select>
        <label class="form-label" for="udm">UNIDAD DE MEDIDA</label>
    </div>
    </div>

    <div class="col-md-3">
      <div class="form-outline">
        <select class="form-select" name="category" id="category">
          <option value="Consumible" {{ isset($product) && $product->category == 'Consumible' ? 'selected' : '' }}>CONSUMIBLE</option>
          <option value="No Consumible" {{ isset($product) && $product->category == 'No Consumible' ? 'selected' : '' }}>NO CONSUMIBLE</option>
          <option value="Producto Almacenable" {{ isset($product) && $product->category == 'Producto Almacenable' ? 'selected' : '' }}>PRODUCTO ALMACENABLE</option>
          <option value="Servicio" {{ isset($product) && $product->category == 'Servicio' ? 'selected' : '' }}>SERVICIO</option>
        </select>
        <label class="form-label" for="category">CATEGORIA</label>
    </div>
    </div>

</div>

<!-- Segunda fila -->
<div class="row mb-4"> 
  
  <div class="col-md-3">
      <div class="form-outline">
          <input type="text" id="contact_number" name="contact_number" value="{{ isset($supplier) ? $supplier->contact_number : '' }}" class="form-control" maxlength="12" placeholder="OPCIONAL"/>
          <label class="form-label" for="contact_number">NUMERO DE CONTACTO</label>
      </div>
  </div>

  <div class="col-md-3">
    <div class="form-outline">
      <div class="form-outline">
        <input type="number" id="credit_days" name="credit_days" value="{{ isset($supplier) ? $supplier->credit_days : '' }}" class="form-control" />
        <label class="form-label" for="credit_days">DIAS DE CREDITO</label>
       </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-outline">
        <input type="text" id="address" name="address" value="{{isset($supplier) ? $supplier->address : ''}}" class="form-control" placeholder="OPCIONAL" />
        <label class="form-label" for="address">DIRECCIÓN</label>
    </div>
</div>

</div>

<!-- Terccera fila -->
<div class="row mb-4"> 
  
  <div class="col-md-4">
    <div class="form-outline">
        <select id="critic" name="critic" class="form-select">
            <option value="1" {{ isset($supplier) && $supplier->critic ? 'selected' : '' }}>SI</option>
            <option value="0" {{ isset($supplier) && $supplier->critic ? 'selected' : '' }}>NO</option>
        </select>
        <label class="form-label" for="critic">¿PROVEEDOR CRITICO?</label>

    </div>
</div>

<div class="col-md-4">
  <div class="form-outline">
      <select id="single_supplier" name="single_supplier" class="form-select">
        <option value="0" {{ isset($supplier) && $supplier->critic ? 'selected' : '' }}>NO</option>
          <option value="1" {{ isset($supplier) && $supplier->critic ? 'selected' : '' }}>SI</option>
      </select>
      <label class="form-label" for="critic">¿PROVEEDOR UNICO?</label>

  </div>
</div>

<div class="col-md-4">
  <div class="form-outline">
    <select class="form-select" name="currency" id="currency">
      <option value="USD" {{ isset($supplier) && $supplier->currency == 'USD' ? 'selected' : '' }}>USD</option>
      <option value="MXN" {{ isset($supplier) && $supplier->currency == 'MXN' ? 'selected' : '' }}>MXN</option>
    </select>
    <label class="form-label" for="currency">TIPO DE DIVISA</label>

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