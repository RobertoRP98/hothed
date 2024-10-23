@extends('layouts.app')
@section('indexclient')

<div class="container">
 @if(Session::has('message'))
 {{Session::get('message')}}
 @endif   


<div class="container">
    <br>

    <h2>Facturación</h2>
    <div class="container my-4">
        <div class="row">
    
            <!-- Card 1: Total pendiente de facturar (Privadas) -->
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Privadas: Pendiente de Facturar</h5>
                        <p class="card-text display-6">${{ number_format($totalPrivadasPendienteFacturar, 2) }}</p>
                    </div>
                </div>
            </div>
    
            <!-- Card 2: Total pendiente de cobrar vencido (Privadas) -->
            <div class="col-md-4">
                <a href="{{ route('privadas-vencidas') }}">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Privadas Pendiente de Cobrar : Vencido</h5>
                        <p class="card-text display-6">${{ number_format($totalPrivadasVencidas, 2) }}</p>
                    </div>
                </div>
                </a>
            </div>
    
            <!-- Card 3: Total pendiente de cobrar NO vencido (Privadas) -->
            <div class="col-md-4">
                <a href="{{ route('privadas-no-vencidas') }}">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Privadas Pendiente de Cobrar: No Vencido</h5>
                        <p class="card-text display-6">${{ number_format($totalPrivadasNoVencidas, 2) }}</p>
                    </div>
                </div>
                </a>
            </div>
    
            <!-- Card 4: Total pendiente de facturar (Pemex) -->
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">PEMEX: Pendiente de Facturar</h5>
                        <p class="card-text display-6">${{ number_format($totalPublicasPendienteFacturar, 2) }}</p>
                    </div>
                </div>
            </div>
    
            <!-- Card 5: Total vencido (Pemex) -->
            <div class="col-md-4">
                <a href=" {{route('publicas-vencidas')}} ">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body">
                        <h5 class="card-title">PEMEX Pendiente de Cobrar: Vencido</h5>
                        <p class="card-text display-6">${{ number_format($totalPublicasVencidas, 2) }}</p>
                    </div>
                </div>
                </a>
            </div>
    
            <!-- Card 6: Total pendiente de cobrar NO vencido (Pemex) -->
            <div class="col-md-4">
                <a href="{{ route('publicas-no-vencidas')}}">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">PEMEX Pendiente de Cobrar: No Vencido</h5>
                        <p class="card-text display-6">${{ number_format($totalPublicasNoVencidas, 2) }}</p>
                    </div>
                </div>
                </a>
            </div>
        </div>
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
        Crear Empresas
    </a> </button> 

    <button type="button" class="btn btn-outline-success mb-3 mt-3 m-2"> <a class="text-dark" href="{{ url('divisas/') }}">
        Tipo de cambio
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
