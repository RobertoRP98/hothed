<!-- resources/views/layouts/navbar.blade.php -->
<nav class="navbar navbar-expand-md navbar-light shadow-sm color-hothed">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">
        <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto">
            <img src="{{ asset('images/logo.png') }}" alt="" width="70" height="70" class="d-inline-block align-text-center">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link text-white {{ request()->is('/') ? 'active' : '' }}">Inicio</a>
                </li>

                @auth
                @if(Auth::user()->hasRole(['Cobranza', 'AdministracionKarla', 'VerCobranza','Developer']))
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ url('facturas') }}">Reporte de cobro</a>
                    </li>
                @endif
            @endauth

            @auth
            @if(Auth::user()->hasRole(['Almacen','Developer']))
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('/almacen-herramientas') }}">Almacen Herramientas</a>
                </li>
            @endif
        @endauth

            @auth
            @php
                // Determinar la ruta según el rol del usuario
                $comprasUrl = '/mis-requisiciones'; // Enlace por defecto
                if (Auth::user()->hasRole(['Developer', 'RespCompras'])) {
                    $comprasUrl = '/requisiciones';
                } elseif (Auth::user()->hasRole('Coordconta')) {
                    $comprasUrl = '/requisiciones-contabilidad';
                } elseif (Auth::user()->hasRole('Coordalm')) {
                    $comprasUrl = '/requisiciones-almacen';
                }
                 elseif (Auth::user()->hasRole('Subgerope')) {
                    $comprasUrl = '/requisiciones-subope';
                } elseif (Auth::user()->hasRole('Gerope')) {
                    $comprasUrl = '/requisiciones-gerope';
                } elseif (Auth::user()->hasRole('Respsgi')) {
                    $comprasUrl = '/requisiciones-sgi';
                } elseif (Auth::user()->hasRole('Diradmin')) {
                    $comprasUrl = '/requisiciones-administracion';
                } elseif (Auth::user()->hasRole('Dirope')) {
                    $comprasUrl = '/requisiciones-dirope';
                
                } elseif (Auth::user()->hasRole('Coordcontratos')) {
                    $comprasUrl = 'requisiciones-contratos';
                }
            @endphp
        
             <li class="nav-item">
                <a class="nav-link text-white" href="{{ url($comprasUrl) }}">Requisiciones</a>
            </li> 
        @endauth 

    
        @auth
        @php
            // Determinar la ruta según el rol del usuario
            $comprasUrl = '#'; // Enlace por defecto
            if (auth()->user()->hasRole(['Developer', 'RespCompras', 'Diradmin'])) {
                $comprasUrl = '/ordenes-compra/pre-autorizacio/adm/pendientes';
            }
            if (auth()->user()->hasRole(['Developer', 'Gerope'])) {
                $comprasUrl = '/ordenes-compra/pre-autorizacio/ope/pendientes';
            }
        @endphp
    
        @if($comprasUrl !== '#')
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ url($comprasUrl) }}">Pre-OC</a>
            </li>
        @endif
    @endauth

    @auth
    @php
        // Determinar la ruta según el rol del usuario
        $comprasUrl = '#'; // Enlace por defecto
        if (auth()->user()->hasRole(['Developer', 'RespCompras', 'Diradmin'])) {
            $comprasUrl = '/ordenes-compra/autorizacion/pendientes';
        }
       
    @endphp

    @if($comprasUrl !== '#')
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ url($comprasUrl) }}">AUT-OC</a>
        </li>
    @endif
@endauth

{{-- @auth
@php
    // Determinar la ruta según el rol del usuario
    $comprasUrl = '#'; // Enlace por defecto
    if (auth()->user()->hasRole(['Contamex'])) {
        $comprasUrl = '/ordenes-compra/autorizacion/autorizadas';
    }
   
@endphp

@if($comprasUrl !== '#')
    <li class="nav-item">
        <a class="nav-link text-white" href="{{ url($comprasUrl) }}">Compras Autorizadas</a>
    </li>
@endif
@endauth --}}
@auth
@php
    // Determinar la ruta según el rol del usuario
    $comprasUrl = '#'; // Enlace por defecto
    if (auth()->user()->hasRole(['Developer', 'RespCompras',])) {
        $comprasUrl = '/ordenes-compra/autorizacion/pendientes/responsable';
    }
@endphp

@if($comprasUrl !== '#')
    <li class="nav-item">
        <a class="nav-link text-white" href="{{ url($comprasUrl) }}">AUT-OC-RESP</a>
    </li>
@endif
@endauth

        @auth
        @php
            // Determinar la ruta según el rol del usuario
            $comprasUrl = '#'; // Enlace por defecto
            if (auth()->user()->hasRole(['Developer', 'RespCompras',])) {
                $comprasUrl = '/ordenes-compra';
            }
        @endphp
    
        @if($comprasUrl !== '#')
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ url($comprasUrl) }}">Ordenes de Compra</a>
            </li>
        @endif
    @endauth

         {{-- //vista para norma  --}}
         @auth
         @php
             // Determinar la ruta según el rol del usuario
             $comprasUrl = '#'; // Enlace por defecto
             if (auth()->user()->hasRole(['Contamex'])) {
                 $comprasUrl = '/ordenes-compra-autorizadas';
             }
            
         @endphp
     
         @if($comprasUrl !== '#')
             <li class="nav-item">
                 <a class="nav-link text-white" href="{{ url($comprasUrl) }}">OCS-AUTS</a>
             </li>
         @endif
     @endauth
 
      {{-- fin vista norma --}}
 

        {{-- //vista para norma  --}}
        @auth
        @php
            // Determinar la ruta según el rol del usuario
            $comprasUrl = '#'; // Enlace por defecto
            if (auth()->user()->hasRole(['Contamex','Gerope','Diradmin','RespCompras','Auxconta','Coordconta'])) {
                $comprasUrl = '/repositorio-ordenes-compra';
            }
           
        @endphp
    
        @if($comprasUrl !== '#')
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ url($comprasUrl) }}">Historial OCS</a>
            </li>
        @endif
    @endauth

     {{-- fin vista norma --}}
    


            @auth
            @if(Auth::user()->hasRole(['Developer', 'AdministracionKarla']))
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('/register') }}">Registrar personal</a>
                </li>
            @endif
        @endauth

        @guest
        <li class="nav-item">
            <a href="{{ url('/#about') }}" class="nav-link text-white">Misión y Visión</a>
        </li>
        <li class="nav-item">
            <a href="{{ url('/#clients') }}" class="nav-link text-white">Nuestros Clientes</a>
        </li>
        <li class="nav-item">
            <a href="{{ url('/#services') }}" class="nav-link text-white">Nuestros Servicios</a>
        </li>
        <li class="nav-item">
            <a href="{{ url('/#footer') }}" class="nav-link text-white">Contacto</a>
        </li>
    @endguest
    
            </ul>

            <ul class="navbar-nav ms-auto">
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<!-- Bundle Bootstrap script -->
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script> --}}
@push('js')
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script> --}}

@endpush