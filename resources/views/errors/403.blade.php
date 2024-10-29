@extends('layouts.app')
@section('error403')

<div class="container">

    <button type="button" class="btn btn-outline-success mb-3 mt-3">
        <a class="text-dark bg-red-500" href="{{ url('/') }}">
            REGRESAR
        </a>
    </button>

    <img class="img-fluid" src="{{ asset('images/403.png') }}" alt="">
</div>

@endsection
