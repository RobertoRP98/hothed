@extends('layouts.app')
@section('indexclient')

<div class="container">
 @if(Session::has('message'))
 {{Session::get('message')}}
 @endif   


<div class="container">

    <h2>Facturación</h2>
    <div class="row">
    <p class="col-3">Total pendiente de facturar (Privadas) : ${{ $totalPrivadasPendienteFacturar }}</p>
    <p class="col-3">Total Pendiente de Cobrar (Privadas): ${{ $totalPrivadasPendienteCobrar }}</p>

    <p class="col-3">Total Pendiente de Facturar (PEMEX): ${{ $totalPublicasPendienteFacturar }}</p>
    <p class="col-3">Total Pendiente de Cobrar (PEMEX): ${{ $totalPublicasPendienteCobrar }}</p>
    </div>

    <button type="button" class="btn btn-outline-success mb-3 mt-3">
        <a class="text-dark" href="{{ route('empresas.privadas') }}">
            Empresas Privadas
        </a>
    </button>

    <button type="button" class="btn btn-outline-success mb-3 mt-3 m-2"> <a class="text-dark" href="{{ route('empresas.publicas') }}">
        Contratos con PEMEX
    </a> </button> 

    <button type="button" class="btn btn-outline-success mb-3 mt-3 m-2"> <a class="text-dark" href="{{ url('empresas/') }}">
        Empresas
    </a> </button> 

    <button type="button" class="btn btn-outline-success mb-3 mt-3 m-2"> <a class="text-dark" href="{{ url('divisas/') }}">
        Divisas
    </a> </button> 

    <h3>Facturas vencidas</h3>
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
        @foreach($facturas as $factura)
        <tr>
            <td>{{$factura->companyreceivable->name}}</td>
            <td>{{$factura->bill_number}}</td>
            <td>{{$factura->bill_date}}</td>
            <td>{{$factura->entry_date}}</td>
            <td>{{$factura->expiration_date}}</td>
            <td class="table-danger {{$factura->diasExpirados >= 0 ? 'red' : 'black'}}">{{floor($factura->diasExpirados)}}</td>
            <td>{{$factura->total_payment}}</td>            
        </tr>
        @endforeach
    </tbody>
</table>
</div>
</div>
</div>

@endsection
