@extends('layouts.app')
@section('register')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('NOMBRE') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('CORREO INSTITUCIONAL') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="EVITAR USAR GMAIL U OTROS">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="departament" class="col-md-4 col-form-label text-md-end">{{ __('DEPARTAMENTO') }}</label>

                            <div class="form-outline col-md-6">
                                <select class="form-select" name="departament" id="departament">
                                <option value="ADM">ADMINISTRATIVO</option>
                                <option value="OP">OPERATIVO</option>
                                </select>
                        </div>   
                        </div>

                        <div class="row mb-3">
                            <label for="area" class="col-md-4 col-form-label text-md-end">{{ __('AREA') }}</label>

                            <div class="form-outline col-md-6">
                                <select class="form-select" name="area" id="area">
                                <option value="OPERACIONES">OPERACIONES</option>
                                <option value="HSE">HSE</option>
                                <option value="SGI">SGI</option>
                                <option value="ADMINISTRACION">ADMINISTRACIÓ</option>
                                <option value="ALMACEN">ALMACEN</option>
                                <option value="COMPRAS E INDIRECTOS">COMPRAS E INDIRECTOS</option>
                                {{-- <option value="MANTENIMIENTO INFRAESTRUCTURA">MANTENIMIENTO INFRAESTRUCTURA</option> --}}
                                <option value="MANTENIMIENTO HTTAS">MANTENIMIENTO HTTAS</option>
                                <option value="LOGISTICA">LOGISTICA</option>
                                <option value="VENTAS">VENTAS</option>
                                {{-- <option value="SERVICIOS">SERVICIOS</option>
                                <option value="FONDO FIJO">FONDO FIJO</option> --}}
                                <option value="CONTRATOS Y COBRANZA">CONTRATOS Y COBRANZA</option>
                                <option value="RECURSOS HUMANOS">RECURSOS HUMANOS</option>
                                <option value="CONTABILIDAD">CONTABILIDAD</option>
                                <option value="TI">TI</option>
                                </select>
                        </div>   
                        </div>

                        <div class="row mb-3">
                            <label for="area" class="col-md-4 col-form-label text-md-end">{{ __('PUESTO') }}</label>

                            <div class="form-outline col-md-6">
                                <select class="form-select" name="subarea" id="subarea">
                                {{-- <option value="AUXILIAR DE SGI">AUXILIAR DE SGI</option> --}}
                                <option value="RESP. DE SGI">RESP. DE SGI</option>
                                {{-- <option value="AUXILIAR DE HSE">AUXILIAR DE HSE</option> --}}
                                <option value="COORD. DE HSE">COORD. DE HSE</option>
                                <option value="AUXILIAR DE VENTAS Y OP">AUXILIAR DE VENTAS Y OP</option>
                                {{-- <option value="AUXILIAR DE VENTAS">AUXILIAR DE VENTAS</option> --}}
                                {{-- <option value="COORD. DE VENTAS">COORD. DE VENTAS</option> --}}
                                {{-- <option value="AUX DE LOGISTICA">AUX DE LOGISTICA</option> --}}
                                <option value="AUX DE LOGISTICA Y MANTO">AUX DE LOGISTICA Y MANTO</option>
                                {{-- <option value="COORD. DE LOGISTICA">COORD. DE LOGISTICA</option> --}}
                                <option value="AUXILIAR DE ALMACEN">AUXILIAR DE ALMACEN</option>
                                <option value="COORD. DE ALMACEN">COORD. DE ALMACEN</option>
                                {{-- <option value="COORD. DE MANTENIMIENTO">COORD. DE MANTENIMIENTO</option> --}}
                                <option value="OPERATIVOS">OPERATIVOS</option>
                                <option value="COORD. DE RECURSOS HUMANOS">COORD. DE RECURSOS HUMANOS</option>
                                {{-- <option value="AUXILIAR DE RECURSOS HUMANOS">AUXILIAR DE RECURSOS HUMANOS</option> --}}
                                <option value="AUXILIAR DE TI">AUXILIAR DE TI</option>
                                {{-- <option value="RESP. DE TI">RESP. DE TI</option> --}}
                                <option value="COORD. CONTRATOS">COORD. CONTRATOS</option>
                                <option value="AUX. CONTRATOS">AUX. CONTRATOS</option>
                                <option value="COORD. CONTABILIDAD">COORD. CONTABILIDAD</option>
                                <option value="AUXILIAR DE CONTABILIDAD">AUXILIAR DE CONTABILIDAD</option>
                                <option value="RESP. DE COMPRAS">RESP. DE COMPRAS</option>
                                {{-- <option value="AUX. DE COMPRAS">AUX. DE COMPRAS</option> --}}
                                <option value="COORD. ADMINISTRATIVO">COORD. ADMINISTRATIVO</option>
                                {{-- <option value="AUX. ADMINISTRATIVO">AUX. ADMINISTRATIVO</option> --}}
                                {{-- <option value="RESP. MANTENIMIENTO DE INFRAESCTRUCTURA">RESP. MANTENIMIENTO DE INFRAESCTRUCTURA</option> --}}
                                {{-- <option value="RESP. DE SERVICIOS">RESP. DE SERVICIOS</option> --}}
                                {{-- <option value="RESP. FONDO FIJO">RESP. FONDO FIJO</option> --}}
                                <option value="ESP. TECNICO">ESPECIALISTA TÉCNICO</option>
                                <option value="SUB. GER. OPE">SUB. GER. OPE</option>
                                <option value="GER. OPE">GER. OPE</option>
                                <option value="DIR. ADMINISTRACION">DIR. ADMINISTRACIÓN</option>
                                <option value="DIR. OPERACIONES">DIR. OPERACIONES</option>




                                </select>
                        </div>   
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('CONTRASEÑA') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('CONFIRMAR CONTRASEÑA') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
