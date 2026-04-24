@extends('layouts.app')

@section('content')
<style>
    .header-taquilla {
        background-color: #0a0a0a;
        background-image:
            linear-gradient(rgba(255, 255, 255, 0.03) 2px, transparent 2px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.03) 2px, transparent 2px);
        background-size: 50px 50px;
        border-bottom: 2px solid #333;
        position: relative;
    }

    .avatar-neon {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 4px solid #E7FF00;
        box-shadow: 0 0 20px rgba(231, 255, 0, 0.4), inset 0 0 10px rgba(231, 255, 0, 0.1);
        background-color: #1a1a1a;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stat-module {
        background-color: #1A1A1A;
        border: 1px solid #333;
        border-left: 4px solid #E7FF00;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }
    .stat-module:hover {
        background-color: #222;
        box-shadow: -4px 0 15px rgba(231, 255, 0, 0.15);
    }
    .stat-value {
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 800;
        font-size: 2.5rem;
        color: white;
        line-height: 1;
    }
    .stat-label {
        font-family: monospace;
        color: #888;
        font-size: 0.85rem;
        letter-spacing: 2px;
        margin-top: 0.5rem;
    }

    .card-inventario {
        background-color: #1A1A1A;
        border: 1px solid #333;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .card-inventario:hover {
        border-color: #E7FF00;
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(231, 255, 0, 0.1);
    }
    .card-inventario img {
        height: 260px;
        object-fit: cover;
        width: 100%;
        border-bottom: 1px solid #333;
        transition: transform 0.5s ease;
    }
    .card-inventario:hover img {
        transform: scale(1.04);
    }

    .badge-disponible {
        background-color: #000;
        color: #E7FF00;
        border: 2px solid #E7FF00;
        box-shadow: 0 0 10px rgba(231, 255, 0, 0.4);
        font-size: 0.65rem;
        font-weight: 900;
        letter-spacing: 1px;
        padding: 3px 8px;
    }
    .badge-nodisponible {
        background-color: #1a1a1a;
        color: #ff0055;
        border: 1px solid #ff0055;
        font-size: 0.65rem;
        font-weight: 900;
        letter-spacing: 1px;
        padding: 3px 8px;
    }

    .title-graffiti {
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 800;
        font-style: italic;
        text-transform: uppercase;
        color: white;
        font-size: 2rem;
        letter-spacing: -1px;
        position: relative;
        display: inline-block;
    }
    .title-graffiti::after {
        content: "";
        position: absolute;
        bottom: 4px;
        left: 0;
        width: 100%;
        height: 12px;
        background-color: #E7FF00;
        z-index: -1;
        opacity: 0.4;
        transform: skewX(-15deg);
    }
</style>

{{-- NAV VOLVER --}}
<nav class="bg-black py-3 border-bottom border-secondary sticky-top" style="border-color: #333 !important;">
    <div class="container d-flex justify-content-between align-items-center">
        {{-- Botón volver --}}
        <button onclick="history.back()" class="p-0 d-flex align-items-center gap-2 text-white" style="background: none; border: none; cursor: pointer;">
            <span class="material-symbols-outlined" style="color: #E7FF00;">arrow_back</span>
            <span class="font-monospace" style="font-size: 0.85rem; font-weight: 700; letter-spacing: 1px;">VOLVER</span>
        </button>

        {{-- Logo / Inicio --}}
        <a href="{{ url('/') }}" class="text-decoration-none d-flex align-items-center gap-2 text-white">
            <span class="material-symbols-outlined" style="color: #E7FF00;">checkroom</span>
            <span class="stencil-text h5 mb-0">EL ARMARIO</span>
        </a>
    </div>
</nav>

{{-- HEADER PERFIL --}}
<section class="header-taquilla py-5">
    <div class="container">
        <div class="row align-items-center gy-4">

            {{-- Avatar + datos --}}
            <div class="col-lg-6 d-flex align-items-center gap-4">
                <div class="avatar-neon">
                    <span class="material-symbols-outlined text-white" style="font-size: 3.5rem; color: #E7FF00 !important;">person</span>
                </div>
                <div>
                    <h2 class="stencil-text text-white mb-1" style="font-size: 2rem;">
                        {{ '@' . $perfil->nombre_usuario }}
                    </h2>
                    <p class="mb-2 fs-6 font-monospace" style="color: #E7FF00;">
                        {{ $perfil->nombre_completo ?? $perfil->nombre_usuario }}
                    </p>
                    @if($perfil->ciudad)
                    <div class="d-flex align-items-center gap-1 font-monospace small" style="color: #ccc;">
                        <span class="material-symbols-outlined" style="font-size: 1rem; color: #E7FF00;">location_on</span>
                        <span>{{ strtoupper($perfil->ciudad) }}</span>
                    </div>
                    @endif
                    {{-- Si estamos viendo nuestro propio perfil --}}
                    @if(auth()->id() === $perfil->id_usuario)
                        <span class="font-monospace mt-2 d-inline-block" style="font-size: 0.7rem; color: #888; letter-spacing: 2px; text-transform: uppercase;">/// TU PERFIL</span>
                    @endif
                </div>
            </div>

            {{-- Stats --}}
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="stat-module text-center">
                            <div class="stat-value">{{ $camisetas->count() }}</div>
                            <div class="stat-label">PIEZAS SUBIDAS</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-module text-center">
                            <div class="stat-value">{{ $perfil->trueques_exitosos ?? 0 }}</div>
                            <div class="stat-label">TRUEQUES EXITOSOS</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- FRANJA DECORATIVA --}}
<div style="height: 8px; background: repeating-linear-gradient(45deg, #E7FF00, #E7FF00 10px, #000 10px, #000 20px);"></div>

{{-- GRID DE CAMISETAS --}}
<section class="py-5" style="background-color: #050505; min-height: 50vh;">
    <div class="container">

        <h3 class="title-graffiti mb-4">
            @if(auth()->id() === $perfil->id_usuario)
                TU INVENTARIO
            @else
                INVENTARIO DE {{ strtoupper($perfil->nombre_usuario) }}
            @endif
        </h3>

        @if($camisetas->isEmpty())
            <div class="py-5 text-center border" style="border-color: #333 !important; background-color: #1a1a1a;">
                <span class="material-symbols-outlined mb-3" style="font-size: 3rem; color: #555;">inventory_2</span>
                <h4 class="stencil-text text-white">EL ARMARIO ESTÁ VACÍO</h4>
                <p class="font-monospace" style="color: #666;">Este coleccionista aún no ha subido ninguna pieza.</p>
            </div>
        @else
            <div class="row g-4">
                @foreach($camisetas as $camiseta)
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <a href="{{ route('camisetas.show', $camiseta->id) }}" class="text-decoration-none d-block">
                        <div class="card-inventario h-100 position-relative overflow-hidden">
                            {{-- Imagen --}}
                            <div class="overflow-hidden" style="height: 260px;">
                                @if($camiseta->images->isNotEmpty())
                                    <img src="{{ Storage::url($camiseta->images->first()->image_path) }}"
                                         alt="{{ $camiseta->equipo }}">
                                @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center"
                                         style="background-color: #111; height: 260px;">
                                        <span class="material-symbols-outlined" style="font-size: 3rem; color: #444;">image_not_supported</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Badge disponibilidad --}}
                            <div class="position-absolute top-0 end-0 m-2">
                                @if($camiseta->intercambiable)
                                    <span class="badge-disponible font-monospace text-uppercase">DISPONIBLE</span>
                                @else
                                    <span class="badge-nodisponible font-monospace text-uppercase">NO DISP.</span>
                                @endif
                            </div>

                            {{-- Info overlay --}}
                            <div class="p-3" style="background-color: #1a1a1a; border-top: 1px solid #333;">
                                <h5 class="text-white font-monospace fw-bold text-uppercase text-truncate mb-1" style="font-size: 0.95rem;">
                                    {{ $camiseta->equipo }}
                                </h5>
                                <div class="d-flex justify-content-between font-monospace" style="font-size: 0.75rem; color: #888;">
                                    <span>TALLA: <span class="text-white fw-bold">{{ $camiseta->talla }}</span></span>
                                    <span>{{ $camiseta->año }}</span>
                                </div>
                                @if($camiseta->images->count() > 1)
                                <div class="mt-1" style="font-size: 0.7rem; color: #555; font-family: monospace;">
                                    <span class="material-symbols-outlined" style="font-size: 0.85rem; vertical-align: middle;">photo_library</span>
                                    {{ $camiseta->images->count() }} FOTOS
                                </div>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

@endsection
