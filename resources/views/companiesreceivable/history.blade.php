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


<div class="container">
    
<table class="table table-light caption-top table-bordered table-hover">
    <caption class="text-center"> Historial de {{$comp->name}}</caption>
    <thead class="thead-light">
        <tr>
            <th colspan="2" class="text-center">Pendiente Facturar</th>
            <th colspan="2" class="text-center">Pagado</th>
            <th colspan="2" class="text-center">Facturado</th>
        </tr>
        <tr>
            <th class="text-center">MES-AÑO</th>
            <th class="text-center">MONTO</th>
            <th class="text-center">MES-AÑO</th>
            <th class="text-center">MONTO</th>
            <th class="text-center">MES-AÑO</th>
            <th class="text-center">MONTO</th>
        </tr>
    </thead>
    <tbody>
        @foreach($grupofacturas as $monthYear=>$statuses)
        <tr>
            {{-- Pendiente Facturar --}}
            <td class="text-center">{{$monthYear}}</td>
            <td class="text-center">{{ isset($statuses['pendiente_facturar']) ? '$' . number_format($statuses['pendiente_facturar'],2) : '-' }}</td>

            {{-- Pagado --}}
            <td class="text-center">{{$monthYear}}</td>
            <td class="text-center">{{isset($statuses['pagado']) ? '$' . number_format($statuses['pagado'],2) : '-'}}</td>

            {{-- Facturado --}}
            <td class="text-center">{{$monthYear}}</td>
            <td class="text-center">{{isset($statuses['pendiente_cobrar']) ? '$' . number_format($statuses['pendiente_cobrar'],2): '-'}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
</div>

@endsection
