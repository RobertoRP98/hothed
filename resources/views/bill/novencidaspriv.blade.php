@extends('layouts.app')
@section('indexclient')

<div class="container">
 @if(Session::has('message'))
 {{Session::get('message')}}
 @endif   


 <div class="container">
    <br>
    <button type="button" class="btn btn-outline-success mb-3 mt-3 m-2"> <a class="text-dark" href="{{ route('facturas.index') }}">
      Regresar
  </a> </button> 
    <h2>Empresas Privadas Pendiente de Cobrar NO Vencidas</h2>

    <div class="table-responsive">
      <table class="table table-bordered table-hover">
          <thead class="thead-light">
              <tr>
                  <th>CLIENTE</th>
                  <th>NO.FACTURA</th>
                  <th>FECHA FACTURA</th>
                  <th>FECHA DE ENTRADA</th>
                  <th>FECHA DE EXPIRACIÓN</th>
                  <th>DIAS ANTES DE VENCER</th>
                  <th>TOTAL</th>
              </tr>
          </thead>
          <tbody>
              @foreach($facturasprivnov as $vencidapriv)
              <tr>
                  <td>{{$vencidapriv->companyreceivable->name}}</td>
                  <td>{{$vencidapriv->bill_number}}</td>
                  <td>{{$vencidapriv->bill_date}}</td>
                  <td>{{$vencidapriv->entry_date}}</td>
                  <td>{{$vencidapriv->expiration_date}}</td>
                  <td class="table-success {{$vencidapriv->diasExpirados < 0 ? 'gree' : 'black'}}">{{floor($vencidapriv->diasExpirados)}}</td>
                  <td>{{$vencidapriv->total_payment}}</td>            
              </tr>
              @endforeach
          </tbody>
      </table>
      </div>
      


 </div>
</div>
@endsection
