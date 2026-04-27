@extends('layouts.app')

@section('content')
<!-- NAVEGACIÓN SUPERIOR -->
<nav class="bg-black py-3 border-bottom border-secondary">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ url('/') }}" class="text-decoration-none d-flex align-items-center text-white custom-hover">
            <span class="material-symbols-outlined me-2" style="color: #ccff00;">checkroom</span>
            <span class="stencil-text h4 mb-0">EL ARMARIO</span>
        </a>
    </div>
</nav>

<section class="py-5 bg-black d-flex align-items-center" style="min-height: 80vh;">
    <div class="container text-center" style="max-width: 800px;">
        <div class="p-5 border" style="background-color: #1a1a1a; border-color: #333 !important;">
            <div class="mb-4">
                <span class="material-symbols-outlined text-white" style="font-size: 5rem; animation: pulse 2s infinite;">sync</span>
            </div>
            
            <h1 class="stencil-text text-white mb-4" style="font-size: clamp(1.5rem, 5vw, 2.5rem);">
                ESPERANDO RESPUESTA DE <br><span style="color: #ccff00; font-size: clamp(2rem, 7vw, 3rem);">{{ '@' . ($objetivo->user->nombre_usuario ?? 'USUARIO') }}</span>
            </h1>
            
            <p class="font-monospace text-light mb-5 fs-5">
                Tu propuesta de trueque ({{ $oferta->equipo }}) por la pieza ({{ $objetivo->equipo }}) ha sido enviada. Te avisaremos cuando haya novedades en la bandeja de entrada.
            </p>
            
            <a href="{{ url('/') }}" class="btn py-4 px-5 fw-bold font-monospace" style="background-color: #ccff00; color: #000; border: none; font-size: 1.2rem; text-transform: uppercase;">
                VOLVER AL INICIO
            </a>
        </div>
    </div>
</section>

<style>
    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; color: #ccff00; }
        50% { transform: scale(1.1); opacity: 0.7; color: #fff; }
        100% { transform: scale(1); opacity: 1; color: #ccff00; }
    }
</style>

<script>
    setTimeout(function() {
        window.location.href = "{{ url('/') }}";
    }, 6000);
</script>
@endsection
