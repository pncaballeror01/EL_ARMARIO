@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary: #E7FF00;
        --danger: #FF0055;
        --bg-darker: #050505;
        --bg-panel: #111;
        --border-color: #333;
        --text-muted: #666;
    }

    body {
        background-color: var(--bg-darker);
        color: white;
    }

    .edit-container {
        max-width: 600px;
        margin: 120px auto 50px auto; /* 120px gives space for the fixed navbar */
        background-color: var(--bg-panel);
        border: 1px solid var(--border-color);
        padding: 3rem;
        box-shadow: 0 0 20px rgba(0,0,0,0.5);
    }

    .section-title {
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 900;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 2rem;
        text-transform: uppercase;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 1rem;
    }
    .section-title::before {
        content: '#';
        color: var(--primary);
    }

    .form-label {
        color: var(--primary);
        font-family: monospace;
        font-weight: bold;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .form-control-custom {
        background-color: #000;
        border: 1px solid #444;
        color: white;
        border-radius: 0;
        padding: 10px 15px;
        font-family: monospace;
        transition: all 0.3s ease;
        width: 100%;
        margin-bottom: 1.5rem;
    }

    .form-control-custom:focus {
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 10px rgba(231, 255, 0, 0.2);
    }

    .btn-action {
        border: none;
        padding: 12px 24px;
        font-family: 'Space Grotesk', sans-serif;
        font-weight: bold;
        font-size: 0.9rem;
        text-transform: uppercase;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s;
        border-radius: 0;
    }

    .btn-save {
        background-color: var(--primary);
        color: black;
        box-shadow: 0 0 15px rgba(231, 255, 0, 0.2);
        flex: 1;
    }
    .btn-save:hover {
        background-color: #fff;
        box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
    }

    .btn-cancel {
        background-color: transparent;
        border: 1px solid #444;
        color: white;
    }
    .btn-cancel:hover {
        background-color: #222;
        border-color: #666;
    }
</style>

{{-- Navbar del panel de administración --}}
@include('admin.partials.navbar')

<div class="container">
    <div class="edit-container">
        <div class="section-title">EDITAR PERFIL DE USUARIO</div>

        @if($errors->any())
            <div class="alert alert-danger border-0 rounded-0 font-monospace mb-4" style="background-color: var(--danger); color: white;">
                <ul class="mb-0 pl-3">
                    @foreach($errors->all() as $error)
                        <li>> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.updateUser', $user->id_usuario) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label">Nombre de Usuario (Apodo)</label>
                <input type="text" name="nombre_usuario" class="form-control-custom" value="{{ old('nombre_usuario', $user->nombre_usuario) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nombre Completo</label>
                <input type="text" name="nombre_completo" class="form-control-custom" value="{{ old('nombre_completo', $user->nombre_completo) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Correo Electrónico (Email)</label>
                <input type="email" name="email" class="form-control-custom" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Ciudad / Ubicación</label>
                <input type="text" name="ciudad" class="form-control-custom" value="{{ old('ciudad', $user->ciudad) }}">
            </div>

            <div class="d-flex gap-3 mt-5">
                <a href="{{ route('admin.dashboard') }}" class="btn-action btn-cancel">
                    <span class="material-symbols-outlined" style="font-size: 1.2rem;">arrow_back</span>
                    VOLVER
                </a>
                <button type="submit" class="btn-action btn-save">
                    <span class="material-symbols-outlined" style="font-size: 1.2rem;">save</span>
                    GUARDAR CAMBIOS
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
