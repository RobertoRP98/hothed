@extends('layouts.app')
@section('indexclient')

<div class="container">
 @if(Session::has('message'))
 {{Session::get('message')}}
 @endif   


 <button type="button" class="btn btn-outline-success mb-3 mt-3 m-2">
    <a class="text-dark" href="{{ url('catalogo/' . $comp->id) }} ">
        Regresar
    </a>
</button>

<h2>Facturas Pagadas</h2>
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
            @foreach ($paidBills as $bill)
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
                            <a class="text-white" href="{{ route('facturas.edit', [$comp->id, $bill->id]) }}">Editar Factura</a> 
                        </button> 

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
</div>
@endsection
