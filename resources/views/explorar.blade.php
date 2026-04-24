@extends('layouts.app')

@section('content')
<style>
    /* Estilos Urbanos Explorar */
    .title-banner {
        background-color: #0a0a0a;
        background-image:
            linear-gradient(rgba(231, 255, 0, 0.03) 2px, transparent 2px),
            linear-gradient(90deg, rgba(231, 255, 0, 0.03) 2px, transparent 2px);
        background-size: 20px 20px;
        border-bottom: 2px solid var(--primary-color, #ccff00);
        position: relative;
    }
    .page-title {
        font-family: Impact, 'Space Grotesk', sans-serif;
        font-size: 3.5rem;
        font-weight: 900;
        text-transform: uppercase;
        color: white;
        letter-spacing: 1px;
    }
    
    .card-grial {
        background-color: #1A1A1A;
        border: 1px solid #333;
        border-radius: 0;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .card-grial:hover {
        border-color: #ccff00;
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(204, 255, 0, 0.15);
    }
    .card-grial img {
        height: 250px;
        width: 100%;
        object-fit: cover;
        border-bottom: 2px solid #333;
    }
    .card-grial:hover img {
        border-color: #ccff00;
    }
    .badge-fluor {
        background-color: #000;
        border: 2px solid #ccff00;
        color: #ccff00;
        padding: 4px 10px;
        font-family: monospace;
        font-size: 11px;
        font-weight: 900;
        text-transform: uppercase;
        box-shadow: 0 0 10px rgba(204, 255, 0, 0.4);
    }
    
    .btn-trato {
        background-color: transparent;
        border: 2px solid #555;
        color: white;
        text-transform: uppercase;
        font-family: monospace;
        font-weight: bold;
        padding: 0.5rem 1rem;
        border-radius: 0;
        width: 100%;
        transition: all 0.2s;
    }
    .card-grial:hover .btn-trato {
        border-color: #ccff00;
        background-color: #ccff00;
        color: #000;
    }
    
    /* Paginación Oscuro/Flúor */
    .pagination-fluor .page-item .page-link {
        background-color: #1A1A1A;
        border: 1px solid #333;
        color: white;
        font-family: monospace;
        padding: 0.5rem 1rem;
    }
    .pagination-fluor .page-item.active .page-link {
        background-color: #ccff00;
        border-color: #ccff00;
        color: black;
        font-weight: bold;
    }
    .pagination-fluor .page-item .page-link:hover {
        background-color: #ccff00;
        border-color: #ccff00;
        color: black;
    }
    .pagination-fluor .disabled .page-link {
        background-color: #111;
        color: #555;
        border-color: #333;
    }
</style>

<!-- NAVEGACIÓN SUPERIOR (VOLVER) -->
<nav class="bg-black py-3 border-bottom border-secondary">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ auth()->check() ? route('dashboard') : route('welcome') }}" class="text-decoration-none d-flex align-items-center text-white custom-hover">
            <span class="material-symbols-outlined text-primary me-2" style="color: #ccff00">arrow_back</span>
            <span class="material-symbols-outlined me-2" style="color: #ccff00">checkroom</span>
            <span class="stencil-text h4 mb-0">EL ARMARIO</span>
        </a>
    </div>
</nav>

<div class="title-banner py-5 px-3">
    <div class="container text-center">
        <h1 class="page-title mb-0">CATÁLOGO DEL <span style="color:#ccff00;">ARMARIO</span></h1>
        <p class="font-monospace mt-2 text-white">/// EXPLORA PIEZAS ÚNICAS LISTAS PARA INTERCAMBIO ///</p>
        
        <div class="mt-4 mx-auto" style="max-width: 800px;">
            <!-- SEARCH FORM (Bootstrap) -->
            <div class="p-3 p-md-4 border text-start" style="background-color: #000; border-color: #ccff00 !important; box-shadow: 0 0 15px rgba(231,255,0,0.15);">
                <h4 class="stencil-text text-center mb-3" style="color: #ccff00; font-size: 1.25rem;">/// PROTOCOLO DE BÚSQUEDA</h4>
                <form action="{{ route('explorar') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label font-monospace small mb-1" style="color: #bcba9a;">EQUIPO</label>
                            <input type="text" name="equipo" class="form-control rounded-0 font-monospace text-white" style="background-color: #111; border: 1px solid #333;" placeholder="Ej: Real Madrid" value="{{ request('equipo') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label font-monospace small mb-1" style="color: #bcba9a;">TALLA</label>
                            <select name="talla" class="form-select rounded-0 font-monospace text-white" style="background-color: #111; border: 1px solid #333;">
                                <option value="">TODAS</option>
                                <option value="S" {{ request('talla') == 'S' ? 'selected' : '' }}>S</option>
                                <option value="M" {{ request('talla') == 'M' ? 'selected' : '' }}>M</option>
                                <option value="L" {{ request('talla') == 'L' ? 'selected' : '' }}>L</option>
                                <option value="XL" {{ request('talla') == 'XL' ? 'selected' : '' }}>XL</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label font-monospace small mb-1" style="color: #bcba9a;">AÑO</label>
                            <input type="number" name="año" class="form-control rounded-0 font-monospace text-white" style="background-color: #111; border: 1px solid #333;" placeholder="Ej: 2005" value="{{ request('año') }}">
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn w-100 font-monospace fw-bold text-black" style="background-color: #ccff00; border-radius: 0;">
                                INICIAR BÚSQUEDA <span class="material-symbols-outlined align-middle ms-2">search</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<section class="py-5 bg-black" style="min-height: 60vh;">
    <div class="container">
        @if($camisetas->isEmpty())
            <div class="p-5 border border-secondary text-center" style="background-color: #1a1a1a;">
                <span class="material-symbols-outlined mb-3 text-secondary" style="font-size: 3rem;">inventory_2</span>
                <h4 class="stencil-text text-white">NO HAY CAMISETAS DISPONIBLES EN ESTE MOMENTO</h4>
                <p class="font-monospace text-muted mb-0">Pronto llegarán nuevas joyas al catálogo.</p>
            </div>
        @else
            <div class="row g-4 mb-5">
                @foreach($camisetas as $cam)
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="card-grial">
                            <div class="position-relative">
                                @if($cam->images->isNotEmpty())
                                    <img src="{{ Storage::url($cam->images->first()->image_path) }}" alt="{{ $cam->equipo }}">
                                @else
                                    <div class="w-100 bg-dark d-flex align-items-center justify-content-center" style="height: 250px;">
                                        <span class="material-symbols-outlined text-white-50" style="font-size: 3rem;">image_not_supported</span>
                                    </div>
                                @endif
                                <div class="position-absolute top-0 end-0 p-2">
                                    <span class="badge-fluor">DISPONIBLE</span>
                                </div>
                            </div>
                            <div class="p-3 d-flex flex-column flex-grow-1">
                                <h5 class="text-white font-monospace fw-bold text-uppercase mb-1">{{ $cam->equipo }}</h5>
                                <div class="font-monospace text-white small d-flex justify-content-between mb-2 opacity-75">
                                    <span>TALLA: {{ $cam->talla }}</span>
                                    <span>{{ $cam->año }}</span>
                                </div>
                                @if($cam->user)
                                <div class="mb-3">
                                    <a href="{{ route('usuario.perfil', $cam->user->id_usuario) }}"
                                       class="font-monospace text-decoration-none d-flex align-items-center gap-1"
                                       style="font-size: 0.72rem; color: #E7FF00; letter-spacing: 1px; transition: opacity 0.2s, text-decoration 0.2s;"
                                       onmouseover="this.style.opacity='0.7'; this.style.textDecoration='underline';"
                                       onmouseout="this.style.opacity='1'; this.style.textDecoration='none';">
                                        <span class="material-symbols-outlined" style="font-size: 0.9rem;">person</span>
                                        {{ $cam->user->nombre_usuario }}
                                    </a>
                                </div>
                                @endif
                                <div class="mt-auto">
                                    <a href="{{ route('intercambio.create', $cam->id) }}" class="btn text-decoration-none btn-trato d-flex align-items-center justify-content-center gap-2">
                                        <span class="material-symbols-outlined fs-5">handshake</span> HAGAMOS TRATO
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Paginación Laravel -->
            <div class="d-flex justify-content-center mt-4">
                <nav aria-label="Navegación de joyas">
                    {{ $camisetas->appends(request()->query())->links('pagination::bootstrap-5') }}
                </nav>
            </div>
            
            <!-- Estilos forzados para la paginación de bootstrap-5 si se carga (Para que sea oscuro/flúor) -->
            <style>
                .pagination {
                    --bs-pagination-bg: #1A1A1A;
                    --bs-pagination-border-color: #333;
                    --bs-pagination-color: white;
                    --bs-pagination-hover-bg: #ccff00;
                    --bs-pagination-hover-color: black;
                    --bs-pagination-hover-border-color: #ccff00;
                    --bs-pagination-focus-bg: #ccff00;
                    --bs-pagination-active-bg: #ccff00;
                    --bs-pagination-active-border-color: #ccff00;
                    --bs-pagination-active-color: black;
                    --bs-pagination-disabled-bg: #111;
                    --bs-pagination-disabled-color: #555;
                    --bs-pagination-disabled-border-color: #333;
                }
                .pagination .page-link {
                    font-family: monospace;
                    text-transform: uppercase;
                    border-radius: 0 !important;
                    margin: 0 2px;
                }
            </style>
        @endif
    </div>
</section>
@endsection
