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
                $comprasUrl = '#'; // Enlace por defecto
                if (Auth::user()->hasRole(['Developer', 'RespCompras'])) {
                    $comprasUrl = '/requisiciones';
                } elseif (Auth::user()->hasRole('AdmCompras')) {
                    $comprasUrl = '/requisiciones-adm';
                } elseif (Auth::user()->hasRole('OpeCompras')) {
                    $comprasUrl = '/requisiciones-ope';
                } elseif (Auth::user()->hasRole('ClientCompras')) {
                    $comprasUrl = '/mis-requisiciones';
                }
            @endphp
        
             <li class="nav-item">
                <a class="nav-link text-white" href="{{ url($comprasUrl) }}">Compras</a>
            </li> 
        @endauth 




            @auth
            @if(Auth::user()->hasRole(['Developer', 'AdministracionKarla']))
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('/register') }}">Registrar personal</a>
                </li>
            @endif
        @endauth

                <li class="nav-item">
                    <a href="{{ url('/#about') }}" class="nav-link text-white {{ request()->is('#misionvision') ? 'active' : '' }}">Misión y Visión</a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/#clients') }}" class="nav-link text-white {{ request()->is('#clientes') ? 'active' : '' }}">Nuestros Clientes</a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/#services') }}" class="nav-link text-white {{ request()->is('#servicios') ? 'active' : '' }}">Nuestros Servicios</a>
                </li>
                
                <li class="nav-item">
                    <a href="{{ url('/#footer') }}" class="nav-link text-white {{ request()->is('#contacto') ? 'active' : '' }}">Contacto</a>
                </li>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
