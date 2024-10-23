@extends('layouts.app')
@section('indexclient')

<div class="container">
 @if(Session::has('message'))
 {{Session::get('message')}}
 @endif   


 <div class="container">   
   <button type="button" class="btn btn-outline-success mb-3 mt-3 m-2"> <a class="text-dark" href="{{ route('facturas.index') }}">
      Regresar
  </a> </button> 
    <h3>Facturas de Empresas Privadas Vencidas</h3>
    <br>
    
    <div class="table-responsive">
<table class="table table-bordered table-hover">
    <thead class="thead-light">
        <tr>
            <th>CLIENTE</th>
            <th>NO.FACTURA</th>
            <th>FECHA FACTURA</th>
            <th>FECHA DE ENTRADA</th>
            <th>FECHA DE EXPIRACIÓN</th>
            <th>DIAS VENCIDOS</th>
            <th>TOTAL</th>
        </tr>
    </thead>
    <tbody>
        @foreach($facturasprivvenc as $vencidapriv)
        <tr>
            <td>{{$vencidapriv->companyreceivable->name}}</td>
            <td>{{$vencidapriv->bill_number}}</td>
            <td>{{$vencidapriv->bill_date}}</td>
            <td>{{$vencidapriv->entry_date}}</td>
            <td>{{$vencidapriv->expiration_date}}</td>
            <td class="table-danger {{$vencidapriv->diasExpirados >= 0 ? 'red' : 'black'}}">{{floor($vencidapriv->diasExpirados)}}</td>
            <td>{{$vencidapriv->total_payment}}</td>            
        </tr>
        @endforeach
    </tbody>
</table>
</div>
 </div>
</div>
@endsection
