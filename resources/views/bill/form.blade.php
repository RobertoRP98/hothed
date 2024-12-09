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
  <input type="hidden" name="companyreceivable_id" value="{{ $company->id }}">
  
    <div class="col-md-3">
        <div class="form-outline">
            <input type="text" id="order_number" name="order_number" value="{{ isset($bill) ? $bill->order_number : '' }}" class="form-control" />
            <label class="form-label" for="NO. DE ORDEN">NO. DE ORDEN</label>
        </div>
    </div>

    <div class="col-md-3">
      <div class="form-outline">
          <input type="text" id="bill_number" name="bill_number" value="{{isset($bill) ? $bill->bill_number : ''}}" class="form-control" />
          <label class="form-label" for="NO. FACTURA">NO. FACTURA</label>
      </div>
  </div>

  <div class="col-md-2">
    <div class="form-outline">
        <input type="date" id="bill_date" name="bill_date" value="{{isset($bill) ? $bill->bill_date : ''}}" class="form-control" />
        <label class="form-label" for="FECHA DE LA FACTURA">FECHA DE LA FACTURA</label>
    </div>
</div>

<div class="col-md-2">
  <div class="form-outline">
      <input type="date" id="entry_date" name="entry_date" value="{{isset($bill) ? $bill->entry_date : ''}}" class="form-control" />
      <label class="form-label" for="FECHA DE LA FACTURA">FECHA DE INGRESO DE LA FACTURA</label>
   </div>
 </div>

 <div class="col-md-2">
  <div class="form-outline">
      <input type="number" id="diascredito" name="diascredito" value="" class="form-control" placeholder="VERIFICAR ANTES DE ACTUALIZAR"/>
      <label class="form-label" for="DIAS DE CREDITO">DIAS DE CREDITO (VERIFICAR) </label>
  </div>
</div>

</div>

<!-- Segunda fila -->
<div class="row mb-4">  
  <div class="col-md-3">
    <div class="form-outline">
        <input type="date" id="expiration_date" name="expiration_date" value="{{ $expirationDate ?? '' }}" class="form-control" readonly/>
        <label class="form-label" for="VENCIMIENTO">VENCIMIENTO</label>
    </div>
</div>

<div class="col-md-3">
  <div class="form-outline">
      <input type="text" id="diasexpirados" name="diasexpirados" value="{{isset($bill) ? floor(\Carbon\Carbon::parse($bill->expiration_date)->diffInDays(now())) : '' }}" class="form-control" readonly/>
      <label class="form-label" for="FECHA DE LA FACTURA">DIAS POR EXPIRAR/EXPIRADOS</label>
   </div>
 </div> 

    <div class="col-md-3">
        <div class="form-outline">
            <input type="text" id="description" name="description" value="{{isset($bill) ? $bill->description : ''}}" class="form-control" />
            <label class="form-label" for="DESCRIPCIÓN">DESCRIPCIÓN</label>
        </div>
    </div>

    <div class="col-md-3">
      <div class="form-outline">
          <input type="text" id="oil_well" name="oil_well" value="{{isset($bill) ? $bill->oil_well : ''}}" class="form-control text-uppercase" />
          <label class="form-label" for="POZO">
            @if ($company->type==='Pemex')
            DISTRITO
            @else
            POZO
            @endif  
          </label>
      </div>
  </div>   
</div>

<!-- Tercera fila -->
<div class="row mb-4">
@if($company->currency === 'MIXTA')
  <div class="col-md-2">
    @else
    <div class="col-md-3">
      @endif
    <div class="form-outline">
        <input type="date" id="start_operation" name="start_operation" value="{{isset($bill) ? $bill->start_operation : ''}}" class="form-control" />
        <label class="form-label" for="INICIO DE OPERACIÓN">INICIO DE OPERACIÓN</label>
    </div>
</div>

@if($company->currency === 'MIXTA')
  <div class="col-md-2">
    @else
    <div class="col-md-3">
      @endif
  <div class="form-outline">
      <input type="date" id="end_operation" name="end_operation" value="{{isset($bill) ? $bill->end_operation : ''}}" class="form-control" />
      <label class="form-label" for="FIN DE OPERACIÓN">FIN DE OPERACIÓN</label>
   </div>
 </div> 

    <div class="col-md-3">
        <div class="form-outline">
            <input type="number" step="0.01" id="total_payment" name="total_payment" value="{{isset($bill) ? $bill->total_payment : ''}}" class="form-control" />
            <label class="form-label" for="IMPORTE">IMPORTE</label>
        </div>
    </div>


    @if($company->currency === 'MIXTA')
    <div class="col-md-2">
      <div class="form-outline">
    <select class="form-select" name="currency" id="currency" required>
        <option value="USD" {{ old('currency', $bill->currency ?? 'USD') === 'USD' ? 'selected' : '' }}>USD</option>
        <option value="MXN" {{ old('currency', $bill->currency ?? 'USD') === 'MXN' ? 'selected' : '' }}>MXN</option>
    </select>
    <label for="currency" class="form-label">Divisa</label>
  </div>   
</div>
@else
    <input type="hidden" name="currency" value="{{ $company->currency }}">
@endif 

    <div class="col-md-3">
      <div class="form-outline">
          <select class="form-select" name="status" id="status">
          <option value="pendiente_facturar" {{isset($bill) && $bill->status == 'pendiente_facturar' ? 'selected':''}}>Pendiente de facturar</option>
          <option value="pendiente_cobrar" {{isset($bill) && $bill->status == 'pendiente_cobrar' ? 'selected':''}}>Pendiente de cobrar</option>
          <option value="pagado" {{isset($bill) && $bill->status == 'pagado' ? 'selected':''}}>Pagado</option>
          <option value="aclaración" {{isset($bill) && $bill->status == 'aclaración' ? 'selected':''}}>Aclaración</option>
          <option value="pendiente_entrada" {{isset($bill) && $bill->status == 'pendiente_entrada' ? 'selected':''}}>Pendiente de entrada</option>
          <option value="cancelado" {{isset($bill) && $bill->status == 'cancelado' ? 'selected':''}}>Cancelado</option>
          </select>
          <label class="form-label" for="IMPORTE">STATUS</label>
  </div>   
</div>

<!-- Cuarta fila -->
<div class="row mb-4">  

  <div class="col-md-3">
    <div class="form-outline">
        <input type="date" id="payment_day" name="payment_day" value="{{isset($bill) ? $bill->payment_day : ''}}" class="form-control" />
        <label class="form-label" for="FECHA DE PAGO">FECHA DE PAGO</label>
    </div>
</div>


    <div class="col-md-3">
        <div class="form-outline">
            <input type="text" id="comentary" name="comentary" value="{{isset($bill) ? $bill->comentary : ''}}" class="form-control" />
            <label class="form-label" for="COMENTARIO">
              @if($company->type==='Pemex')
                POZO
                @else 
                COMENTARIO
                @endif
            </label>
        </div>
    </div>

    @if($company->name === 'PEMEX CONTRATO TOMS  646203854')
    <div class="col-md-3">
      <div class="form-outline">
          <select id="porcent" name="porcent" class="form-select">
              <option value="1" {{ isset($bill) && $bill->porcent ? 'selected' : '' }}>Primera Factura</option>
              <option value="0" {{ isset($bill) && !$bill->porcent ? 'selected' : '' }}>Segunda o + Factura</option>
          <label class="form-label" for="porcent">Tipo de Factura</label>
          </select>
      </div>
  </div>
  @endif
  
       
</div>

<br>
 <!-- Submit button -->
 <div class="row mb-4 col-md-6">

 <button type="submit" class="btn btn-primary btn-block col-md-3 m-1">{{$modo}} Factura</button>
 
 <button type="button" class="btn btn-warning btn-block col-md-3 m-1"> <a class="text-white" href="{{ url('catalogo/' . $company->id) }}">
    Regresar
</a> </button> 

 </div>