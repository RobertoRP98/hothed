@extends('layouts.app')
@section('indexclient')

<div class="container">
 @if(Session::has('message'))
 {{Session::get('message')}}
 @endif   

    <h1>{{ $empresa->name }}</h1>

    <div>
        <button type="button" class="btn btn-outline-success mb-3 mt-3">
            <a class="text-dark" href="{{ route('prefactura.create', ['companyreceivable_id' => $empresa->id]) }}">
                Crear nuevo
            </a>
        </button>
    </div>

    <h2>Totales</h2>
    <div class="row">
    <p class="col-3">Total Global: {{ $totalGlobal }}</p>
    <p class="col-3">Total Pendiente de Facturar: {{ $totalPendienteFacturar }}</p>
    <p class="col-3">Total Pendiente de Cobrar: {{ $totalPendienteCobrar }}</p>
    <p class="col-3">Total Pagado: {{ $totalPagado }}</p>
    </div>

    <h2>Facturas</h2>
    <table class="table table-light">
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
            @foreach ($empresa->bills as $bill)
                <tr>
                    <td>{{ $bill->order_number }}</td>
                    <td>{{ $bill->bill_number }}</td>
                    <td>{{ $bill->bill_date }}</td>
                    <td>{{ $bill->entry_date }}</td>
                    <td>{{ $bill->expiration_date }}</td>
                    <td> {{ floor(\Carbon\Carbon::parse($bill->expiration_date)->diffInDays(now())) }} </td>
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
@endsection
