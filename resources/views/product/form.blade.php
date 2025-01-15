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
            <input type="text" id="internal_id" name="internal_id" value="{{ old('internal_id', isset($product) ? $product->internal_id : '' )}}" class="form-control text-uppercase" placeholder="ESTE IDENTIFICADOR ES UNICO"/>
            <label class="form-label">IDENTIFICADOR INTERNO</label>
        </div>
    </div>

    <div class="col-md-6">
      <div class="form-outline">
          <input type="text" id="description" name="description" value="{{ old('description',isset($product) ? $product->description : '' )}}" class="form-control text-uppercase" placeholder="NOMBRE DEL PRODUCTO"/>
          <label class="form-label">DESCRIPCIÓN</label>
      </div>
  </div>

  <div class="col-md-3">
    <div class="form-outline">
        <input type="text" id="brand" name="brand" value="{{ old('brand',isset($product) ? $product->brand : '' )}}" class="form-control text-uppercase"/>
        <label class="form-label">MARCA DEL PRODUCTO</label>
    </div>
</div>
    

</div>

<!-- Segunda fila -->
<div class="row mb-4">  

  <div class="col-md-2">
    <div class="form-outline">
        <input type="number" id="quantity" name="quantity" value="{{ old('quantity',isset($product) ? $product->quantity : 0 )}}" class="form-control" />
        <label class="form-label">CANTIDAD</label>
    </div>
  </div>
  
  <div class="col-md-2">
    <div class="form-outline">
        <input type="number" id="min_stock" name="min_stock" value="{{ old('min_stock',isset($product) ? $product->min_stock : 0 )}}" class="form-control" />
        <label class="form-label">STOCK MINIMO</label>
    </div>
  </div>

  <div class="col-md-2">
    <div class="form-outline">
        <input type="number" id="max_stock" name="max_stock" value="{{ old('max_stock',isset($product) ? $product->max_stock : 0 )}}" class="form-control" />
        <label class="form-label">STOCK MAXIMO</label>
    </div>
  </div>

  <div class="col-md-3">
    <div class="form-outline">
      <select class="form-select" name="udm" id="udm"> <option value="PIEZAS" {{ old('udm', isset($product) && $product->udm == 'PIEZAS' ? 'selected' : '') }}>PIEZAS</option> <option value="KG" {{ old('udm', isset($product) && $product->udm == 'KG' ? 'selected' : '') }}>KGS</option> <option value="LITROS" {{ old('udm', isset($product) && $product->udm == 'LITROS' ? 'selected' : '') }}>LITROS</option> <option value="SERVICIO" {{ old('udm', isset($product) && $product->udm == 'SERVICIO' ? 'selected' : '') }}>SERVICIO</option> <option value="KILOMETROS" {{ old('udm', isset($product) && $product->udm == 'KILOMETROS' ? 'selected' : '') }}>KILOMETROS</option> <option value="METROS" {{ old('udm', isset($product) && $product->udm == 'METROS' ? 'selected' : '') }}>METROS</option> <option value="METROS CUBICOS" {{ old('udm', isset($product) && $product->udm == 'METROS CUBICOS' ? 'selected' : '') }}>METROS CUBICOS</option> <option value="METROS CUADRADOS" {{ old('udm', isset($product) && $product->udm == 'METROS CUADRADOS' ? 'selected' : '') }}>METROS CUADRADOS</option> <option value="LIBRAS" {{ old('udm', isset($product) && $product->udm == 'LIBRAS' ? 'selected' : '') }}>LIBRAS</option> <option value="GALONES" {{ old('udm', isset($product) && $product->udm == 'GALONES' ? 'selected' : '') }}>GALONES</option> <option value="CUBETAS" {{ old('udm', isset($product) && $product->udm == 'CUBETAS' ? 'selected' : '') }}>CUBETAS</option> <option value="TAMBORES" {{ old('udm', isset($product) && $product->udm == 'TAMBORES' ? 'selected' : '') }}>TAMBORES</option> <option value="JUEGOS" {{ old('udm', isset($product) && $product->udm == 'JUEGOS' ? 'selected' : '') }}>JUEGOS</option> <option value="HORAS" {{ old('udm', isset($product) && $product->udm == 'HORAS' ? 'selected' : '') }}>HORAS</option> <option value="DIAS" {{ old('udm', isset($product) && $product->udm == 'DIAS' ? 'selected' : '') }}>DIAS</option>
        </select>
        <label class="form-label">UNIDAD DE MEDIDA</label>
  </div>   
  </div>

  <div class="col-md-3">
    <div class="form-outline">
        <select class="form-select" name="category" id="category">
        <option value="ACCESORIO" {{old('category',isset($product) && $product->category == 'ACCESORIO' ? 'selected':'')}}>ACCESORIO</option>
        <option value="CONSUMIBLE" {{old('category',isset($product) && $product->category == 'CONSUMIBLE' ? 'selected':'')}}>CONSUMIBLE</option>
        <option value="EMPAQUES" {{old('category',isset($product) && $product->category == 'EMPAQUES' ? 'selected':'')}}>EMPAQUES</option>
        <option value="EPP" {{old('category',isset($product) && $product->category == 'EPP' ? 'selected':'')}}>EPP</option>
        <option value="HERRAMIENTA" {{old('category',isset($product) && $product->category == 'HERRAMIENTA' ? 'selected':'')}}>HERRAMIENTA</option>
        <option value="REFACCION" {{old('category',isset($product) && $product->category == 'REFACCION' ? 'selected':'')}}>REFACCIÓN</option>
        <option value="TORQUE" {{old('category',isset($product) && $product->category == 'TORQUE' ? 'selected':'')}}>TORQUE</option>
        <option value="SERVICIO" {{old('category',isset($product) && $product->category == 'SERVICIO' ? 'selected':'')}}>SERVICIO</option>
        </select>
        <label class="form-label">CATEGORIA</label>
  </div>   
  </div>
</div>

<!-- Tercera fila -->
<div class="row mb-4">

  <div class="col-md-4">
    <div class="form-outline">
        <input type="number" step="0.01" id="price" name="price" value="{{old('price',isset($product) ? $product->price : 0)}}" class="form-control" />
        <label class="form-label">PRECIO</label>
    </div>
</div>

<div class="col-md-4">
  <div class="form-outline">
      <input type="number" id="discount" name="discount" value="{{old('discount',isset($product) ? $product->discount : 0)}}" class="form-control" placeholder="ENTEROS 5,8,10 ETC" />
      <label class="form-label">DESCUENTO (5,10,8,ETC)</label>
  </div>
</div>

<div class="col-md-4">
  <select class="form-select" name="tax_id" id="tax_id">
    @foreach ($taxes as $tax)
        <option value="{{ $tax->id }}" {{ (old('tax_id', $product->tax_id ?? '') == $tax->id) ? 'selected' : '' }}>
            {{ $tax->concept }}
        </option>
    @endforeach
</select>
    <label class="form-label">IMPUESTO</label>
</div>


</div>

<div class="row mb-4">
  <div class="col-md-6">
    <div class="form-outline">
        <input type="text" id="commentary" name="commentary" value="{{ old('commentary',isset($product) ? $product->commentary : '' )}}" class="form-control text-uppercase" placeholder="CAMPO OPCIONAL"/>
        <label class="form-label">COMENTARIO</label>
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