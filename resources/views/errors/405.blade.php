@extends('layouts.app')
@section('error403')

<div class="container">

    <button type="button" class="btn btn-outline-success mb-3 mt-3">
        <a class="text-dark bg-red-500" href="{{ url('/') }}">
            REGRESAR
        </a>
    </button>

    <h1 class="text-danger ">SITIO EN CONSTRUCCIÓN</h1>

    <img class="img-fluid" src="{{ asset('images/405.png') }}" alt="">
</div>

@endsection
