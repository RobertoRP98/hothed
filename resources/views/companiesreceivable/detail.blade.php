@extends('layouts.app')
@section('indexclient')

<div class="container">
 @if(Session::has('message'))
 {{Session::get('message')}}
 @endif   

    <h1>{{ $empresa->name }}</h1>

    <div>
        <button type="button" class="btn btn-outline-success mb-3 mt-3 m-2"> 
            <a class="text-dark" 
            @if($empresa->type == 'Privada')
            href="{{route('empresas.privadas')}}"
            @else href="{{route('empresas.publicas')}}"
            @endif>
            Regresar
        </a> </button> 
        
        <button type="button" class="btn btn-outline-success mb-3 mt-3 ">
            <a class="text-dark" href="{{ route('prefactura.create', ['companyreceivable_id' => $empresa->id]) }}">
                Crear nuevo
            </a>
        </button>

        <button type="button" class="btn btn-outline-success mb-3 mt-3 m-2">
            <a class="text-dark" href="{{route('empresa.historial', ['company' => $empresa->id]) }} ">
                Historial General
            </a>
        </button>

        <button type="button" class="btn btn-outline-success mb-3 mt-3 m-1">
            <a class="text-dark" href="{{route('empresa.facturas-pagadas', ['company' => $empresa->id]) }} ">
                Historial pagados
            </a>
        </button>
    </div>

    <h2>Totales</h2>
    <div class="container my-4">
        <div class="row">

            <div class="col-md-3">
                <div class="card text-white bg-secondary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Historico: </h5>
                        <p class="card-text display-6">${{ number_format($totalGlobal, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Pendiente de facturar: </h5>
                        <p class="card-text display-6">${{ number_format($totalPendienteFacturar, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body">
                        <h5 class="card-title"> Pendiente de Cobrar: </h5>
                        <p class="card-text display-6">${{ number_format($totalPendienteCobrar, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Pagado: </h5>
                        <p class="card-text display-6">${{ number_format($totalPagado , 2) }}</p>
                    </div>
                </div>
            </div>


        </div>
    </div>

   

    <h2>Facturas</h2>
    <div class="table-responsive">
    <table class="table table-light table-bordered table-hover">
        <thead class="thead-light">
            <tr>
                <th>No. Orden</th>
                <th>No. Factura</th>
                <th>Fecha de Factura</th>
                <th>Fecha de Ingreso</th>
                <th>Fecha de Expiración</th>
                <th>Días Vencidos o por vencer</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($unpaidBills as $bill)
                <tr>
                    <td>{{ $bill->order_number }}</td>
                    <td>{{ $bill->bill_number }}</td>
                    <td>{{ $bill->bill_date }}</td>
                    <td>{{ $bill->entry_date }}</td>
                    <td>{{ $bill->expiration_date }}</td>
                    <td class="
                    @if($bill->status==='pagado')
                        table-info
                    @elseif(\Carbon\Carbon::parse($bill->expiration_date)->diffInDay(now(),false)>=0)
                        table-danger 
                    @elseif(\Carbon\Carbon::parse($bill->expiration_date)->diffInDay(now(),false)<=-31)
                        table-secondary
                    @else
                        table-warning        
                    @endif    
                    ">
                    {{floor(\Carbon\Carbon::parse($bill->expiration_date)->diffInDay(now(),false))}}
                    </td>
                    <td>
                        <button class="btn btn-warning mb-2">
                            <a class="text-white" href="{{ route('facturas.edit', [$empresa->id, $bill->id]) }}">Editar Factura</a> 
                        </button> 

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
@endsection
