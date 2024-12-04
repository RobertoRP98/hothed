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
  
  <div class="col-md-4">
    <div class="form-outline">
        <input type="number" step="0.01" id="precio" name="precio" value="{{isset($product) ? $product->precio : ''}}" class="form-control" />
        <label class="form-label" for="precio">PRECIO</label>
    </div>
</div>

<div class="col-md-4">
  <div class="form-outline">
      <select class="form-select" name="taxes_id" id="taxes_id">
          <option value="" disabled {{ !isset($product) || is_null($product->taxes_id) ? 'selected' : '' }}>Selecciona un impuesto</option>
          @foreach($impuestos as $impuesto)
              <option 
                  value="{{ $impuesto->id }}" 
                  {{ isset($product) && $product->taxes_id == $impuesto->id ? 'selected' : '' }}>
                  {{ $impuesto->name }}
              </option>
          @endforeach
      </select>
      <label class="form-label" for="taxes_id">IMPUESTO</label>
  </div>
</div>

<div class="col-md-4">
  <div class="form-outline">
      <input type="number"  id="discount" name="discount" value="{{isset($product) ? $product->discount : 0}}" class="form-control" placeholder="10-20-30 ..."/>
      <label class="form-label" for="discount">DESCUENTO</label>
  </div>
</div>

</div>

<!-- Terccera fila -->
<div class="row mb-4"> 

  <div class="col-md-4">
    <div class="form-outline">
        <input type="number" id="min_stock" name="min_stock" value="{{isset($product) ? $product->min_stock : ''}}" class="form-control" />
        <label class="form-label" for="min_stockt">STOCK MINIMO</label>
    </div>
  </div>
  

  <div class="col-md-4">
    <div class="form-outline">
        <input type="date" id="update_date_price" name="update_date_price" value="{{isset($product) ? $product->update_date_price : $today}}" class="form-control"/>
        <label class="form-label" for="min_stockt">ULTIMA ACTUALIZACIÓN</label>
    </div>
  </div>


</div>
<br>
 <!-- Submit button -->
 <div class="row mb-4 col-md-6">

 <button type="submit" class="btn btn-primary btn-block col-md-3 m-1">{{$modo}} Producto</button>
 
 <button type="button" class="btn btn-warning btn-block col-md-3 m-1"> <a class="text-white" href="{{ url('productos/') }}">
    Regresar
</a> </button> 

 </div>