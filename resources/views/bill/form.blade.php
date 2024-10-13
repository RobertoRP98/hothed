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

  <div class="col-md-3">
    <div class="form-outline">
        <input type="date" id="bill_date" name="bill_date" value="{{isset($bill) ? $bill->bill_date : ''}}" class="form-control" />
        <label class="form-label" for="FECHA DE LA FACTURA">FECHA DE LA FACTURA</label>
    </div>
</div>

<div class="col-md-3">
  <div class="form-outline">
      <input type="date" id="entry_date" name="entry_date" value="{{isset($bill) ? $bill->entry_date : ''}}" class="form-control" />
      <label class="form-label" for="FECHA DE LA FACTURA">FECHA DE INGRESO DE LA FACTURA</label>
   </div>
 </div>    
</div>

<!-- Segunda fila -->
<div class="row mb-4">  
  <div class="col-md-3">
    <div class="form-outline">
        <input type="date" id="expiration_date" name="expiration_date" value="{{isset($bill) ? $bill->expiration_date : ''}}" class="form-control" />
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
          <label class="form-label" for="POZO">POZO</label>
      </div>
  </div>   
</div>

<!-- Tercera fila -->
<div class="row mb-4">  
  <div class="col-md-3">
    <div class="form-outline">
        <input type="date" id="start_operation" name="start_operation" value="{{isset($bill) ? $bill->start_operation : ''}}" class="form-control" />
        <label class="form-label" for="INICIO DE OPERACIÓN">INICIO DE OPERACIÓN</label>
    </div>
</div>

<div class="col-md-3">
  <div class="form-outline">
      <input type="date" id="end_operation" name="end_operation" value="{{isset($bill) ? $bill->end_operation : ''}}" class="form-control" />
      <label class="form-label" for="FECHA DE LA FACTURA">FIN DE OPERACIÓN</label>
   </div>
 </div> 

    <div class="col-md-3">
        <div class="form-outline">
            <input type="number" id="total_payment" name="total_payment" value="{{isset($bill) ? $bill->total_payment : ''}}" class="form-control" />
            <label class="form-label" for="IMPORTE">IMPORTE</label>
        </div>
    </div>

    <div class="col-md-3">
      <div class="form-outline">
          <select class="form-select" name="status" id="status">
          <option value="pendiente_facturar" {{isset($bill) && $bill->status == 'pendiente_facturar' ? 'selected':''}}>Pendiente de facturar</option>
          <option value="pendiente_cobrar" {{isset($bill) && $bill->status == 'pendiente_cobrar' ? 'selected':''}}>Pendiente de cobrar</option>
          <option value="pagado" {{isset($bill) && $bill->status == 'pagado' ? 'selected':''}}>Pagado</option>
          <option value="aclaración" {{isset($bill) && $bill->status == 'aclaración' ? 'selected':''}}>Aclaración</option>
          </select>
          <label class="form-label" for="IMPORTE">STATUS</label>
  </div>   
</div>
</div>

<!-- Cuarta fila -->
<div class="row mb-4">  
  <div class="col-md-3">
    <div class="form-outline">
        <input type="date" id="billing_date" name="billing_date" value="{{isset($bill) ? $bill->billing_date : ''}}" class="form-control" />
        <label class="form-label" for="FECHA DE FACTURACIÓN">FECHA DE FACTURACIÓN</label>
    </div>
</div>

  <div class="col-md-3">
    <div class="form-outline">
        <input type="date" id="payment_day" name="payment_day" value="{{isset($bill) ? $bill->payment_day : ''}}" class="form-control" />
        <label class="form-label" for="FECHA DE PAGO">FECHA DE PAGO</label>
    </div>
</div>


    <div class="col-md-3">
        <div class="form-outline">
            <input type="text" id="comentary" name="comentary" value="{{isset($bill) ? $bill->comentary : ''}}" class="form-control" />
            <label class="form-label" for="COMENTARIO">COMENTARIO</label>
        </div>
    </div>

       
</div>

<br>
 <!-- Submit button -->
 <div class="row mb-4 col-md-6">

 <button type="submit" class="btn btn-primary btn-block col-md-3 m-1">{{$modo}} Factura</button>
 
 <button type="button" class="btn btn-warning btn-block col-md-3 m-1"> <a class="text-white" href="{{ url('catalogo/' . $company->id) }}">
    Regresar
</a> </button> 

 </div>