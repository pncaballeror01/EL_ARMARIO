@extends('layouts.app')

@section('content')
<style>
    /* Estilos Específicos del Armario Industrial */
    .header-taquilla {
        background-color: #0a0a0a;
        background-image:
            linear-gradient(rgba(255, 255, 255, 0.03) 2px, transparent 2px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.03) 2px, transparent 2px);
        background-size: 50px 50px;
        border-bottom: 2px solid #333;
        position: relative;
    }
    .header-taquilla::after {
        content: "RESTRICTED AREA";
        position: absolute;
        top: 20px;
        right: 20px;
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 800;
        font-size: 4rem;
        color: rgba(255, 255, 255, 0.02);
        transform: rotate(-10deg);
        pointer-events: none;
        user-select: none;
    }

    .avatar-neon {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 4px solid var(--primary-color);
        box-shadow: 0 0 20px rgba(231, 255, 0, 0.4), inset 0 0 10px rgba(231, 255, 0, 0.4);
        object-fit: cover;
        background-color: #1a1a1a;
        padding: 4px;
    }
    
    .avatar-placeholder {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background-color: #222;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        font-size: 3rem;
    }

    .stat-module {
        background-color: #1A1A1A;
        border: 1px solid #333;
        border-left: 4px solid var(--primary-color);
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

    .btn-mando {
        background-color: var(--primary-color);
        color: #000;
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 1.5rem;
        letter-spacing: 2px;
        border: 3px solid #000;
        box-shadow: 0 6px 0 #000, 0 0 20px rgba(231, 255, 0, 0.3);
        transition: all 0.1s ease;
        width: 100%;
        padding: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        position: relative;
        overflow: hidden;
    }
    .btn-mando::before {
        content: "";
        position: absolute;
        top: 0; left: -100%; width: 50%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        transform: skewX(-20deg);
        transition: all 0.5s ease;
    }
    .btn-mando:hover::before {
        left: 150%;
    }
    .btn-mando:hover {
        transform: translateY(2px);
        box-shadow: 0 4px 0 #000, 0 0 25px rgba(231, 255, 0, 0.5);
    }
    .btn-mando:active {
        transform: translateY(6px);
        box-shadow: 0 0 0 #000, 0 0 15px rgba(231, 255, 0, 0.2);
    }

    .franja-peligro {
        background: repeating-linear-gradient(
            45deg,
            var(--primary-color),
            var(--primary-color) 10px,
            #000 10px,
            #000 20px
        );
        height: 10px;
        width: 100%;
    }

    .title-graffiti {
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 800;
        font-style: italic;
        text-transform: uppercase;
        color: white;
        font-size: 2.5rem;
        letter-spacing: -1px;
        margin-bottom: 2rem;
        position: relative;
        display: inline-block;
    }
    .title-graffiti::after {
        content: "";
        position: absolute;
        bottom: 5px;
        left: 0;
        width: 100%;
        height: 15px;
        background-color: var(--primary-color);
        z-index: -1;
        opacity: 0.5;
        transform: skewX(-15deg);
    }

    .card-inventario {
        background-color: #1A1A1A;
        border: 1px solid #333;
        border-radius: 0;
        transition: all 0.3s ease;
    }
    .card-inventario:hover {
        border-color: #666;
        transform: translateY(-5px);
    }
    .card-inventario img {
        height: 250px;
        object-fit: cover;
        border-bottom: 1px solid #333;
        /* IMPORTANTE: Sin desenfoque, nítido */
        filter: none !important;
    }
    .tech-data {
        font-family: monospace;
        color: #bbb;
        font-size: 0.8rem;
    }
    
    .btn-tech-editar {
        border: 1px solid var(--primary-color);
        color: var(--primary-color);
        background: transparent;
        font-family: monospace;
        font-weight: bold;
        transition: all 0.2s;
        border-radius: 0;
    }
    .btn-tech-editar:hover {
        background: var(--primary-color);
        color: #000;
    }
    
    .btn-tech-eliminar {
        border: 1px solid #555;
        color: #888;
        background: transparent;
        font-family: monospace;
        font-weight: bold;
        transition: all 0.2s;
        border-radius: 0;
    }
    .btn-tech-eliminar:hover {
        border-color: #dc3545;
        color: #dc3545;
        background: rgba(220, 53, 69, 0.1);
    }

    .btn-buzon-landing {
        height: 2.5rem;
        padding: 0 1.5rem;
        border: 2px solid #333;
        font-size: 0.875rem;
        font-family: monospace;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        background-color: rgba(0, 0, 0, 0.4);
        color: white !important;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s ease-in-out;
        text-decoration: none;
    }
    .btn-buzon-landing:hover {
        border-color: white;
    }
    .btn-buzon-badge {
        background-color: #dc2626;
        color: white;
        border-radius: 9999px;
        padding: 0.125rem 0.5rem;
        font-size: 0.65rem;
        line-height: 1;
    }

</style>

<div class="py-1 border-bottom border-dark overflow-hidden" style="background-color: #ccff00 !important;">
    <div class="animate-marquee fw-bold font-monospace small" style="color: #000 !important;">
        <span class="mx-5">ESTADO DEL SISTEMA: OPERATIVO</span>
        <span class="mx-5">USUARIO: {{ strtoupper(Auth::user()->nombre_usuario ?? 'GUEST') }}</span>
        <span class="mx-5">UBICACIÓN: {{ strtoupper(Auth::user()->ciudad ?? 'MADRID HUB') }}</span>
        <span class="mx-5">ESTADO DEL SISTEMA: OPERATIVO</span>
        <span class="mx-5">USUARIO: {{ strtoupper(Auth::user()->nombre_usuario ?? 'GUEST') }}</span>
    </div>
</div>

<!-- NAVEGACIÓN SUPERIOR (VOLVER) -->
<nav class="bg-black py-3 border-bottom border-secondary">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-4">
            <a href="{{ url('/') }}" class="text-decoration-none d-flex align-items-center text-white custom-hover">
                <span class="material-symbols-outlined me-2" style="color: #ccff00">arrow_back</span>
                <span class="material-symbols-outlined me-2" style="color: #ccff00">checkroom</span>
                <span class="stencil-text h4 mb-0">EL ARMARIO</span>
            </a>
            <a href="{{ route('buzon.index') }}" class="btn-buzon-landing">
                <span class="material-symbols-outlined" style="font-size: 1.1rem;">inbox</span>
                BUZÓN
                @if(auth()->check() && auth()->user()->unreadMessagesCount() > 0)
                    <span class="btn-buzon-badge">{{ auth()->user()->unreadMessagesCount() }}</span>
                @endif
            </a>
        </div>
    </div>
</nav>
<style>
    .custom-hover:hover .stencil-text, .custom-hover:hover span { color: #ccff00 !important; }
</style>

<!-- HEADER DEL PERFIL: La Taquilla del Coleccionista -->
<section class="header-taquilla py-5">
    <div class="container relative z-10">
        <div class="row align-items-center gy-4">
            
            <!-- Avatar y Datos -->
            <div class="col-lg-6 d-flex align-items-center gap-4">
                <div class="avatar-neon flex-shrink-0">
                    <!-- Si el usuario no tiene foto, mostrar un icono o inicial -->
                    <div class="avatar-placeholder">
                        <span class="material-symbols-outlined" style="font-size: 4rem;">person</span>
                    </div>
                </div>
                <div>
                    <h2 class="stencil-text text-white mb-1" style="font-size: 2rem;">{{ '@' . (Auth::user()->nombre_usuario ?? 'USUARIO') }}</h2>
                    <p class="mb-2 fs-5 text-uppercase" style="color: #ccff00 !important;">{{ Auth::user()->nombre_usuario ?? 'Usuario' }}</p>
                    <div class="d-flex align-items-center gap-3 font-monospace small text-muted">
                        <span class="d-flex align-items-center gap-1" style="color: #ccff00 !important;">
                            <span class="material-symbols-outlined fs-6" style="color: #ccff00 !important;">location_on</span>
                            {{ Auth::user()->ciudad ?? 'Cargando ciudad...' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Bloques de Estadísticas Industriales -->
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="stat-module text-center h-100 d-flex flex-column justify-content-center">
                            <div class="stat-value">{{ $camisetas->count() }}</div>
                            <div class="stat-label">CAMISETAS</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-module text-center h-100 d-flex flex-column justify-content-center">
                            <div class="stat-value">{{ auth()->user()->trueques_exitosos }}</div>
                            <div class="stat-label">TRUEQUES EXITOSOS</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- BOTÓN PRINCIPAL "SUBIR NUEVA" -->
<section class="bg-black py-4 border-bottom border-dark">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <a href="{{ route('camisetas.create') }}" class="btn-mando text-decoration-none">
                    <span class="material-symbols-outlined" style="font-size: 2rem; font-weight: 800;">power_settings_new</span>
                    + SUBIR NUEVA JOYA AL ARMARIO &rarr;
                </a>
                <div class="franja-peligro mt-2"></div>
            </div>
        </div>
    </div>
</section>

<section class="py-5" style="background-color: #050505; min-height: 50vh;">
    <div class="container">
        
        <h3 class="title-graffiti">TU INVENTARIO ACTIVO</h3>
        
        <div class="row g-4 mt-2">
            
            @forelse($camisetas as $camiseta)
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card card-inventario h-100 position-relative">
                        <a href="{{ route('camisetas.show', $camiseta->id) }}" class="text-decoration-none d-block">
                            <div class="position-relative overflow-hidden" style="height: 350px;">
                                @if($camiseta->images->isNotEmpty())
                                    <img src="{{ Storage::url($camiseta->images->first()->image_path) }}" class="img-fluid w-100 h-100 object-fit-cover rounded-0" alt="Camiseta {{ $camiseta->equipo }}" style="transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                                @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-dark text-white rounded-0">
                                        <span class="material-symbols-outlined fs-1">image_not_supported</span>
                                    </div>
                                @endif
                            </div>
                            <div class="position-absolute bottom-0 start-0 w-100 p-3 bg-black bg-opacity-75 d-flex justify-content-between align-items-center">
                                <h5 class="text-white font-monospace fw-bold text-uppercase mb-0 m-0 text-truncate" style="max-width: 80%;">{{ $camiseta->equipo }}</h5>
                                @if($camiseta->intercambiable)
                                    <span class="badge font-monospace px-2 py-1 text-uppercase" style="background-color: #000; color: #ccff00; border: 2px solid #ccff00 !important; box-shadow: 0 0 10px rgba(204, 255, 0, 0.4); font-size: 0.7rem; font-weight: 900;">DISPONIBLE</span>
                                @else
                                    <span class="badge font-monospace px-2 py-1 text-uppercase" style="background-color: #1a1a1a; color: #ff0055; border: 1px solid #ff0055 !important; font-size: 0.7rem; font-weight: 900;">NO DISPONIBLE</span>
                                @endif
                            </div>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-12 py-5 text-center">
                    <div class="p-5 border border-secondary text-center" style="background-color: #1a1a1a;">
                        <span class="material-symbols-outlined mb-3 text-white-50" style="font-size: 3rem;">inventory_2</span>
                        <h4 class="stencil-text text-white">TU ARMARIO ESTÁ VACÍO</h4>
                        <p class="font-monospace text-light mb-4">Aún no has subido ninguna pieza de colección.</p>
                        <a href="{{ route('camisetas.create') }}" class="btn py-2 px-4 shadow-sm" style="background-color: #ccff00; color: #000; font-family: 'Space Grotesk', sans-serif; font-weight: 800; border: none;">
                            AÑADIR MI PRIMERA CAMISETA
                        </a>
                    </div>
                </div>
            @endforelse
    </div>
</section>

@endsection
