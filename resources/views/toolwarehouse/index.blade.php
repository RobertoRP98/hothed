@extends('layouts.app')
@section('indexcondition')

<div class="container">
    @if(Session::has('message'))
        {{ Session::get('message') }}
    @endif

    <button type="button" class="btn btn-outline-success mb-3 mt-3">
        <a class="text-dark" href="{{ url('almacenherramientas/create') }}">
            Agregar Herramienta
        </a>
    </button>

    <!-- Aquí se integra el componente de búsqueda de Vue -->
    <div id="app">
        <search-component></search-component>
    </div>
</div>

@endsection

