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
    <h2>Contratos de Pemex Pendiente de Cobrar Vencidas</h2>
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
              @foreach($facturaspubvenc as $vencidapub)
              <tr>
                 <td>{{ $vencidapub->companyreceivable->name ?? 'N/A' }}</td> 
                  <td>{{$vencidapub->companyreceivable->name}}</td>
                  <td>{{$vencidapub->bill_number}}</td>
                  <td>{{$vencidapub->bill_date}}</td>
                  <td>{{$vencidapub->entry_date}}</td>
                  <td>{{$vencidapub->expiration_date}}</td>
                  <td class="table-danger {{$vencidapub->diasExpirados >= 0 ? 'red' : 'black'}}">{{floor($vencidapub->diasExpirados)}}</td>
                  <td>{{$vencidapub->total_payment}}</td>            
              </tr>
              @endforeach
          </tbody>
      </table>
      </div>

 </div>
</div>
@endsection
