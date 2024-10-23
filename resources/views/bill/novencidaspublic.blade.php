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
    <h2>Contatos de Pemex Pendiente de Cobrar NO Vencidas</h2>
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
                  <th>DIAS ANTES DE VENCER</th>
                  <th>TOTAL</th>
              </tr>
          </thead>
          <tbody>
              @foreach($facturaspubnov as $novencidapub)
              <tr>
                  <td>{{$novencidapub->companyreceivable->name}}</td>
                  <td>{{$novencidapub->bill_number}}</td>
                  <td>{{$novencidapub->bill_date}}</td>
                  <td>{{$novencidapub->entry_date}}</td>
                  <td>{{$novencidapub->expiration_date}}</td>
                  <td class="table-success {{$novencidapub->diasExpirados < 0 ? 'green' : 'black'}}">{{floor($novencidapub->diasExpirados)}}</td>
                  <td>{{$novencidapub->total_payment}}</td>            
              </tr>
              @endforeach
          </tbody>
      </table>
      </div>


 </div>
</div>
@endsection
