@extends('layouts.app')

@section('content')
    <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center">
        <div class="col-md-4">
            <div class="p-5 bg-black border-armario position-relative">
                <div class="position-absolute top-0 start-0 bg-primary text-black px-2 py-1 fw-bold small font-monospace" style="transform: translateY(-100%);">
                    NEW_USER_SECURE
                </div>

                <h2 class="display-6 stencil-text text-white text-center mb-5">ÚNETE AL <span class="text-primary">GREMIO</span></h2>

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    @if ($errors->any())
                        <div class="alert font-monospace small mb-4 p-3 rounded-0" style="background-color: #ff005520; color: #ff0055; border: 1px solid #ff0055;">
                            <div class="text-uppercase fw-bold mb-1"><span class="material-symbols-outlined align-middle fs-6 me-1">error</span> ACCESO DENEGADO</div>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label text-primary small font-monospace">NOMBRE DE USUARIO</label>
                        <input type="text" name="nombre_usuario" class="form-control" value="{{ old('nombre_usuario') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-primary small font-monospace">CIUDAD</label>
                        <select name="ciudad" class="form-select" required>
                            <option value="" disabled selected>Selecciona tu ciudad principal</option>
                            <option value="Madrid">Madrid</option>
                            <option value="Barcelona">Barcelona</option>
                            <option value="Valencia">Valencia</option>
                            <option value="Sevilla">Sevilla</option>
                            <option value="Zaragoza">Zaragoza</option>
                            <option value="Málaga">Málaga</option>
                            <option value="Murcia">Murcia</option>
                            <option value="Palma">Palma</option>
                            <option value="Las Palmas">Las Palmas</option>
                            <option value="Bilbao">Bilbao</option>
                            <option value="Logroño">Logroño</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-primary small font-monospace">EMAIL</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-4">
                            <label class="form-label text-primary small font-monospace">CONTRASEÑA</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-6 mb-4">
                            <label class="form-label text-primary small font-monospace">REPETIR</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">CREAR CUENTA</button>
                </form>
            </div>
        </div>
    </div>
@endsection
