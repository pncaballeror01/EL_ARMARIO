@extends('layouts.app')

@section('content')

<!-- NAVEGACIÓN SUPERIOR (VOLVER) -->
<nav class="bg-black py-3 border-bottom border-secondary sticky-top">
    <div class="container d-flex justify-content-between align-items-center">
        @if(auth()->id() === $camiseta->user_id)
            <a href="{{ route('armario') }}" class="text-decoration-none d-flex align-items-center text-white custom-hover">
        @else
            <a href="{{ url('/') }}" class="text-decoration-none d-flex align-items-center text-white custom-hover">
        @endif
            <span class="material-symbols-outlined text-primary me-2">arrow_back</span>
            <span class="font-monospace small fw-bold">VOLVER</span>
        </a>
        <a href="{{ url('/') }}" class="text-decoration-none d-flex align-items-center text-white custom-hover">
            <span class="material-symbols-outlined text-primary me-2">checkroom</span>
            <span class="stencil-text h5 mb-0">EL ARMARIO</span>
        </a>
    </div>
</nav>
<style>
    .custom-hover:hover .stencil-text, .custom-hover:hover span { color: #ccff00 !important; }
    
    .gallery-main {
        height: 320px;
        object-fit: cover;
        width: 100%;
        border: 1px solid #333;
    }
    @media (min-width: 576px) {
        .gallery-main { height: 420px; }
    }
    @media (min-width: 992px) {
        .gallery-main { height: 560px; }
    }
    
    .gallery-thumb {
        height: 80px;
        object-fit: cover;
        width: 100%;
        border: 1px solid #333;
        cursor: pointer;
        opacity: 0.6;
        transition: all 0.3s;
    }
    @media (min-width: 576px) {
        .gallery-thumb { height: 100px; }
    }
    @media (min-width: 992px) {
        .gallery-thumb { height: 120px; }
    }
    
    .gallery-thumb:hover, .gallery-thumb.active {
        opacity: 1;
        border-color: #ccff00;
        box-shadow: 0 0 10px rgba(204, 255, 0, 0.3);
    }
    
    .info-panel {
        background-color: #0a0a0a;
        border: 1px solid #333;
        padding: 1.25rem;
    }
    @media (min-width: 768px) {
        .info-panel { padding: 2rem; }
    }

    /* Title size responsive */
    .info-panel h1.stencil-text {
        font-size: 2rem !important;
    }
    @media (min-width: 576px) {
        .info-panel h1.stencil-text { font-size: 2.5rem !important; }
    }
    @media (min-width: 992px) {
        .info-panel h1.stencil-text { font-size: 3rem !important; }
    }

    /* Owner + badge wrap on mobile */
    .info-panel .d-flex.align-items-center.gap-3 {
        flex-wrap: wrap;
        gap: 0.5rem !important;
    }
    
    .btn-buy {
        background-color: #ccff00;
        color: #000;
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 1rem;
        letter-spacing: 1px;
        border: 2px solid #000;
        box-shadow: 0 4px 0 #000;
        transition: all 0.1s ease;
        width: 100%;
    }
    @media (min-width: 576px) {
        .btn-buy { font-size: 1.2rem; letter-spacing: 2px; }
    }
    .btn-buy:hover {
        transform: translateY(2px);
        box-shadow: 0 2px 0 #000;
    }

    /* SWITCH STYLES */
    .form-check-input:checked {
        background-color: #ccff00 !important;
        border-color: #ccff00 !important;
        box-shadow: 0 0 10px rgba(204,255,0,0.5);
    }
    .form-check-input:not(:checked) {
        background-color: #ff0055 !important;
        border-color: #ff0055 !important;
    }
    .form-check-input {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="-4 -4 8 8"><circle r="3" fill="%23000"/></svg>') !important;
    }
</style>

<section class="py-4 py-md-5" style="background-color: #000; min-height: 90vh;">
    <div class="container">
        <div class="row g-5">
            <!-- GALERÍA DE IMÁGENES -->
            <div class="col-lg-7">
                <div class="mb-3 position-relative">
                    @if($camiseta->images->isNotEmpty())
                        <img id="mainImage" src="{{ Storage::url($camiseta->images->first()->image_path) }}" class="gallery-main" alt="{{ $camiseta->equipo }}">
                    @else
                        <div class="gallery-main d-flex justify-content-center align-items-center bg-dark text-white">
                            <span class="material-symbols-outlined fs-1">image_not_supported</span>
                        </div>
                    @endif
                </div>
                <!-- MINIATURAS -->
                <div class="row g-2">
                    @foreach($camiseta->images as $index => $img)
                    <div class="col-3">
                        <img src="{{ Storage::url($img->image_path) }}" class="gallery-thumb {{ $index == 0 ? 'active' : '' }}" onclick="changeImage(this, '{{ Storage::url($img->image_path) }}')">
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- PANEL DE INFORMACIÓN -->
            <div class="col-lg-5">
                <div class="info-panel h-100 d-flex flex-column">
                    <div class="mb-4">
                        <h1 class="stencil-text text-white mb-2" style="font-size: 3rem;">{{ mb_strtoupper($camiseta->equipo) }}</h1>
                        <div class="d-flex align-items-center gap-3">
                            <p class="font-monospace text-light fs-5 mb-0">PROPIETARIO: <a href="{{ route('usuario.perfil', $camiseta->user->id_usuario) }}" class="text-decoration-none" style="color: #E7FF00;">{{ '@' . ($camiseta->user->nombre_usuario ?? 'usuario_desconocido') }}</a></p>
                            @if(auth()->id() === $camiseta->user_id)
                                <form action="{{ route('camisetas.toggle', $camiseta->id) }}" method="POST" class="m-0 p-0">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-check form-switch d-flex align-items-center mb-0 gap-2">
                                        <input class="form-check-input" type="checkbox" role="switch" id="toggleIntercambiable" name="intercambiable" value="1" {{ $camiseta->intercambiable ? 'checked' : '' }} onchange="this.form.submit()" style="cursor: pointer; width: 3em; height: 1.5em; margin-top: 0;">
                                        <label class="form-check-label font-monospace fw-bold" for="toggleIntercambiable" style="color: {{ $camiseta->intercambiable ? '#ccff00' : '#ff0055' }}; font-size: 0.9rem; cursor: pointer; margin-top: 3px;">
                                            {{ $camiseta->intercambiable ? 'DISPONIBLE' : 'NO DISPONIBLE' }}
                                        </label>
                                    </div>
                                </form>
                            @else
                                @if($camiseta->intercambiable)
                                    <span class="badge font-monospace px-2 py-1 text-uppercase" style="background-color: #000; color: #ccff00; border: 2px solid #ccff00 !important; box-shadow: 0 0 10px rgba(204, 255, 0, 0.4); font-size: 0.8rem; font-weight: 900;">DISPONIBLE</span>
                                @else
                                    <span class="badge font-monospace border border-secondary px-2 py-1" style="background-color: #1A1A1A; color: #888; font-size: 0.8rem;">NO DISPONIBLE</span>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="border-top border-bottom border-dark py-4 mb-4">
                        <div class="row g-4 font-monospace">
                            <div class="col-6 mb-2">
                                <span class="d-block text-white small mb-2 opacity-50">EQUIPO/CLUB</span>
                                <span class="text-white fw-bold fs-5">{{ $camiseta->equipo }}</span>
                            </div>
                            <div class="col-6 mb-2">
                                <span class="d-block text-white small mb-2 opacity-50">AÑO / TEMPORADA</span>
                                <span class="text-white fw-bold fs-5">{{ $camiseta->año }}</span>
                            </div>
                            <div class="col-6 mb-2">
                                <span class="d-block text-white small mb-2 opacity-50">TALLA</span>
                                <span class="text-white fw-bold fs-5">{{ $camiseta->talla }}</span>
                            </div>
                            <div class="col-6 mb-2">
                                <span class="d-block text-white small mb-2 opacity-50">ESTADO / CONDICIÓN</span>
                                <span class="text-white fw-bold fs-5" style="color: #ccff00 !important;">{{ $camiseta->estado }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5 flex-grow-1">
                        <h4 class="stencil-text text-white mb-3">DESCRIPCIÓN</h4>
                        <p class="font-monospace text-light" style="line-height: 1.8; white-space: pre-wrap;">{{ $camiseta->descripcion }}</p>
                    </div>

                    <div class="mt-auto">
                        @if(auth()->check() && (auth()->id() === $camiseta->user_id || auth()->user()->isAdmin()))
                            <a href="{{ route('camisetas.edit', $camiseta) }}" class="btn btn-buy py-3 mb-3 d-flex justify-content-center align-items-center gap-2 text-decoration-none">
                                <span class="material-symbols-outlined">edit</span>
                                {{ auth()->user()->isAdmin() && auth()->id() !== $camiseta->user_id ? 'MODERAR DATOS (ADMIN)' : 'EDITAR PUBLICACIÓN' }}
                            </a>

                            <form action="{{ route('camisetas.destroy', $camiseta) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta publicación permanentemente?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn py-3 d-flex justify-content-center align-items-center gap-2" 
                                    style="background-color: transparent; color: #dc3545; border: 2px solid #dc3545; font-family: 'Space Grotesk', sans-serif; font-weight: 800; font-size: 1.2rem; width: 100%; transition: all 0.2s;" 
                                    onmouseover="this.style.backgroundColor='#dc3545'; this.style.color='#fff';" 
                                    onmouseout="this.style.backgroundColor='transparent'; this.style.color='#dc3545';">
                                    <span class="material-symbols-outlined">delete_forever</span>
                                    {{ auth()->user()->isAdmin() && auth()->id() !== $camiseta->user_id ? 'ELIMINAR POR INCUMPLIMIENTO' : 'ELIMINAR PUBLICACIÓN' }}
                                </button>
                            </form>
                        @else
                            @if($camiseta->intercambiable)
                                <a href="{{ route('intercambio.create', $camiseta->id) }}" class="btn btn-buy py-3 d-flex justify-content-center align-items-center gap-2 text-decoration-none">
                                    <span class="material-symbols-outlined">swap_calls</span>
                                    PROPONER TRUEQUE
                                </a>
                            @else
                                <button class="btn py-3 d-flex justify-content-center align-items-center gap-2" disabled style="background-color: #1A1A1A; border: 2px solid #333; color: #555; width: 100%; font-family: 'Space Grotesk', sans-serif; font-weight: 800; text-transform: uppercase;">
                                    <span class="material-symbols-outlined">block</span>
                                    NO DISPONIBLE PARA TRUEQUE
                                </button>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function changeImage(element, src) {
        // Cambiar imagen principal
        document.getElementById('mainImage').src = src;
        
        // Actualizar thumbnails
        document.querySelectorAll('.gallery-thumb').forEach(el => el.classList.remove('active'));
        element.classList.add('active');
    }
</script>

@endsection
