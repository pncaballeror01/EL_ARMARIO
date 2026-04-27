@extends('layouts.app')

@section('content')
    <div class="container min-vh-100 d-flex align-items-center justify-content-center py-4">
        <div class="col-11 col-sm-8 col-md-5 col-lg-4">
            <div class="p-4 p-md-5 bg-black border-primary-armario shadow-lg position-relative">

                <div class="text-center mb-5">
                    <span class="material-symbols-outlined display-4 mb-2" style="color: var(--primary-color)">token</span>
                    <h2 class="stencil-text h2 text-white">ACCESO <span style="color: var(--primary-color)">SEGURO</span></h2>
                </div>

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    
                    @if ($errors->any())
                        <div class="alert font-monospace small mb-4 p-3 rounded-0" style="background-color: #ff005520; color: #ff0055; border: 1px solid #ff0055;">
                            <span class="material-symbols-outlined align-middle fs-6 me-2">error</span>
                            {{ $errors->first() }} 
                        </div>
                    @endif

                    <div class="mb-4">
                        <label class="form-label font-monospace small text-uppercase" style="color: var(--primary-color)">Correo Electrónico</label>
                        <input type="text" name="email" class="form-control" placeholder="EMAIL DE USUARIO" value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-5">
                        <label class="form-label font-monospace small text-uppercase" style="color: var(--primary-color)">Contraseña</label>
                        <input type="password" name="password" class="form-control" placeholder="********" required>
                    </div>

                    <button type="submit" class="btn btn-primary-armario w-100 py-3 fs-5 mb-4">ENTRAR AL ARMARIO</button>
                </form>

                <div class="text-center mt-4">
                    <p class="text-secondary small font-monospace mb-1">> ¿SIN CUENTA?</p>
                    <a href="{{ route('register') }}" class="fw-bold text-uppercase" style="color: var(--primary-color) !important; border-bottom: 2px solid var(--primary-color); text-decoration: none;">
                        REGÍSTRATE AQUÍ
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
