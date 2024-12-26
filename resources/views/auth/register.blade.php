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
                                <option value="MANTENIMIENTO INFRAESTRUCTURA">MANTENIMIENTO INFRAESTRUCTURA</option>
                                <option value="MANTENIMIENTO HTTAS">MANTENIMIENTO HTTAS</option>
                                <option value="LOGISTICA">LOGISTICA</option>
                                <option value="VENTAS">VENTAS</option>
                                <option value="SERVICIOS">SERVICIOS</option>
                                <option value="FONDO FIJO">FONDO FIJO</option>
                                <option value="CONTRATOS Y COBRANZA">CONTRATOS Y COBRANZA</option>
                                <option value="RECURSOS HUMANOS">RECURSOS HUMANOS</option>
                                <option value="CONTABILIDAD">CONTABILIDAD</option>
                                <option value="TI">TI</option>
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
