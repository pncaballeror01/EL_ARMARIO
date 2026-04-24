@extends('layouts.app')

@section('content')
<style>
    /* Estilos Pantalla de Negociación */
    .title-banner {
        background-color: #0a0a0a;
        background-image:
            linear-gradient(rgba(231, 255, 0, 0.03) 2px, transparent 2px),
            linear-gradient(90deg, rgba(231, 255, 0, 0.03) 2px, transparent 2px);
        background-size: 20px 20px;
        border-bottom: 2px solid #ccff00;
    }
    .page-title {
        font-family: Impact, 'Space Grotesk', sans-serif;
        font-size: 4rem;
        font-weight: 900;
        text-transform: uppercase;
        color: #ccff00;
        letter-spacing: 1px;
    }
    
    .section-title {
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 800;
        font-size: 1.5rem;
        color: white;
        border-left: 5px solid #ccff00;
        padding-left: 10px;
        margin-bottom: 1.5rem;
        text-transform: uppercase;
    }

    .card-objetivo {
        background-color: #1A1A1A;
        border: 2px dashed #ccff00;
        padding: 1rem;
    }

    /* Radio buttons ocultos con imágenes seleccionables */
    .radio-card {
        cursor: pointer;
        display: block;
        height: 100%;
    }
    .radio-card input[type="radio"] {
        display: none;
    }
    .radio-card .card-content {
        height: 100%;
        border: 2px solid #333;
        background-color: #1A1A1A;
        transition: all 0.2s;
        display: flex;
        flex-direction: column;
    }
    .radio-card .card-content img {
        height: 200px;
        object-fit: cover;
        width: 100%;
        border-bottom: 1px solid #333;
    }
    .radio-card input[type="radio"]:checked + .card-content {
        border-color: #ccff00;
        box-shadow: 0 0 15px rgba(204, 255, 0, 0.3);
        background-color: rgba(204, 255, 0, 0.05);
    }
    .radio-card input[type="radio"]:checked + .card-content .check-icon {
        color: #ccff00;
        opacity: 1;
    }
    
    .check-icon {
        position: absolute;
        top: 10px;
        right: 10px;
        color: #fff;
        opacity: 0.2;
        background: rgba(0,0,0,0.5);
        border-radius: 50%;
        padding: 5px;
    }

    .input-tactical {
        background-color: #000 !important;
        border: 2px solid #333 !important;
        color: white !important;
        border-radius: 0 !important;
        padding: 1rem;
        font-family: monospace;
        transition: all 0.2s;
    }
    .input-tactical:focus {
        border-color: #ccff00 !important;
        box-shadow: 0 0 10px rgba(204, 255, 0, 0.2) !important;
        outline: none !important;
    }

    .btn-propuesta {
        background-color: #ccff00;
        color: #000;
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 900;
        font-size: 1.8rem;
        text-transform: uppercase;
        border: none;
        border-radius: 0;
        padding: 1.5rem;
        width: 100%;
        transition: all 0.3s;
        margin-top: 1rem;
        box-shadow: 0 6px 0 #99aa00;
    }
    .btn-propuesta:hover {
        transform: translateY(2px);
        box-shadow: 0 4px 0 #99aa00, 0 5px 15px rgba(204, 255, 0, 0.4);
        background-color: #f0ff33;
    }
    .btn-propuesta:active {
        transform: translateY(6px);
        box-shadow: none;
    }
</style>

<!-- NAVEGACIÓN SUPERIOR (VOLVER) -->
<nav class="bg-black py-3 border-bottom border-secondary">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ url()->previous() }}" class="text-decoration-none d-flex align-items-center text-white custom-hover">
            <span class="material-symbols-outlined me-2" style="color: #ccff00;">arrow_back</span>
            <span class="font-monospace fw-bold">VOLVER</span>
        </a>
    </div>
</nav>

<div class="title-banner py-4 px-3 text-center">
    <h1 class="page-title mb-0">HAGAMOS TRATO.</h1>
    <p class="font-monospace mt-2 text-white">SYS.REQ // INICIAR PROTOCOLO DE INTERCAMBIO</p>
</div>

<section class="py-5 bg-black" style="min-height: 70vh;">
    <div class="container" style="max-width: 1000px;">
        <form action="{{ route('intercambio.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id_objetivo" value="{{ $objetivo->id }}">
            
            <div class="row g-5">
                
                <!-- Columna Izquierda: OBJETIVO -->
                <div class="col-md-5">
                    <h3 class="section-title">TU OBJETIVO</h3>
                    <div class="card-objetivo text-center mb-4">
                        @if($objetivo->images->isNotEmpty())
                            <img src="{{ Storage::url($objetivo->images->first()->image_path) }}" class="img-fluid border border-secondary mb-3" alt="{{ $objetivo->equipo }}">
                        @else
                            <div class="w-100 bg-dark d-flex align-items-center justify-content-center mb-3 border border-secondary" style="height: 300px;">
                                <span class="material-symbols-outlined text-white-50 fs-1">image_not_supported</span>
                            </div>
                        @endif
                        <h4 class="text-white font-monospace fw-bold text-uppercase">{{ $objetivo->equipo }}</h4>
                        <div class="text-light font-monospace small">
                            <p class="mb-1">TALLA: {{ $objetivo->talla }} | AÑO: {{ $objetivo->año }}</p>
                            <p class="mb-0">ESTADO: {{ $objetivo->estado }}</p>
                            <p class="mb-0 mt-2" style="color: #ccff00;">PROPIETARIO: {{ '@' . ($objetivo->user->nombre_usuario ?? 'Desconocido') }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Columna Derecha: OFERTA Y NOTA -->
                <div class="col-md-7">
                    <h3 class="section-title">TU OFERTA <span class="text-light fs-6 d-block mt-1">SELECCIONAR DE MI ARMARIO</span></h3>
                    
                    @if($misCamisetas->isEmpty())
                        <div class="p-4 border border-secondary text-center" style="background-color: #1a1a1a;">
                            <span class="material-symbols-outlined text-light fs-1 mb-2">error</span>
                            <h5 class="text-white stencil-text">NO TIENES JOYAS INTERCAMBIABLES</h5>
                            <p class="font-monospace text-light small">Debes subir al menos una camiseta marcada como "Intercambiable" para poder hacer ofertas.</p>
                            <a href="{{ route('camisetas.create') }}" class="btn btn-outline-light mt-2 font-monospace fw-bold px-4" style="border-color: #ccff00; color: #ccff00;">SUBIR CAMISETA</a>
                        </div>
                    @else
                        <div class="row g-3 mb-4" style="max-height: 400px; overflow-y: auto;">
                            @foreach($misCamisetas as $miCam)
                                <div class="col-6 col-sm-4">
                                    <label class="radio-card position-relative w-100">
                                        <input type="radio" name="id_oferta" value="{{ $miCam->id }}" required>
                                        <div class="card-content">
                                            @if($miCam->images->isNotEmpty())
                                                <img src="{{ Storage::url($miCam->images->first()->image_path) }}" alt="{{ $miCam->equipo }}">
                                            @else
                                                <div class="w-100 bg-dark d-flex align-items-center justify-content-center" style="height: 150px;">
                                                    <span class="material-symbols-outlined text-white-50 fs-2">inventory</span>
                                                </div>
                                            @endif
                                            <div class="p-2 text-center flex-grow-1 d-flex align-items-center justify-content-center">
                                                <span class="text-white font-monospace small text-uppercase">{{ $miCam->equipo }}</span>
                                            </div>
                                            <span class="material-symbols-outlined check-icon">check_circle</span>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    

                    
                    @if($misCamisetas->isNotEmpty())
                        <button type="submit" id="btnSubmitPropuesta" class="btn-propuesta d-flex justify-content-center align-items-center gap-2" disabled style="opacity: 0.5; background-color: #555; box-shadow: none; color: #fff;">
                            <span class="material-symbols-outlined">send</span> ENVIAR PROPUESTA
                        </button>
                    @else
                        <button type="button" class="btn-propuesta" disabled style="opacity: 0.5; background-color: #555; box-shadow: none; color: #fff;">
                            ENVIAR PROPUESTA
                        </button>
                    @endif
                </div>

            </div>
        </form>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const radios = document.querySelectorAll('.radio-card input[type="radio"]');
        const btn = document.getElementById('btnSubmitPropuesta');
        
        radios.forEach(radio => {
            // Eliminar requerido de HTML5 para gestionarlo via JS y poder desmarcar
            radio.removeAttribute('required');
            
            radio.addEventListener('click', function(e) {
                if (this.wasChecked) {
                    this.checked = false;
                    this.wasChecked = false;
                } else {
                    radios.forEach(r => r.wasChecked = false);
                    this.wasChecked = true;
                }
                updateSubmitButton();
            });
        });
        
        function updateSubmitButton() {
            if (!btn) return;
            const isChecked = document.querySelector('.radio-card input[type="radio"]:checked');
            if (isChecked) {
                btn.removeAttribute('disabled');
                btn.style.opacity = '1';
                btn.style.backgroundColor = '#ccff00';
                btn.style.color = '#000';
            } else {
                btn.setAttribute('disabled', 'disabled');
                btn.style.opacity = '0.5';
                btn.style.backgroundColor = '#555';
                btn.style.color = '#fff';
            }
        }
    });
</script>
@endsection
