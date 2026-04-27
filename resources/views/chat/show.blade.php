@extends('layouts.app')

@section('content')
<nav class="bg-black py-2 md:py-3 border-bottom border-secondary fixed-top">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ route('buzon.index') }}" class="text-decoration-none d-flex align-items-center text-white custom-hover">
            <span class="material-symbols-outlined me-1 md:me-2" style="color: #ccff00">arrow_back</span>
            <span class="stencil-text fs-6 fs-md-5 mb-0 d-none d-sm-block">VOLVER AL BUZÓN</span>
            <span class="stencil-text fs-6 fs-md-5 mb-0 d-sm-none">VOLVER</span>
        </a>
        <div class="d-flex align-items-center gap-2">
            <div class="w-[35px] h-[35px] md:w-[40px] md:h-[40px] rounded-circle d-flex align-items-center justify-content-center bg-[#222]" style="border: 2px solid var(--primary-color);">
                <span class="material-symbols-outlined text-primary fs-6 md:fs-5">person</span>
            </div>
            <span class="stencil-text text-white fs-6 md:fs-5 text-truncate" style="max-width: 150px;">{{ strtoupper($otherUser->nombre_usuario) }}</span>
        </div>
    </div>
</nav>

<section class="bg-grid-metal" style="background-color: #050505; min-height: 100vh; padding-top: 80px; padding-bottom: 120px;">
    <div class="container mt-4" style="max-width: 800px;">
        
        <div class="d-flex flex-column gap-3">
            @foreach($messages as $msg)
                @if($msg->system_type === 'info')
                    <div class="text-center my-3">
                        <span class="badge border border-secondary font-monospace px-3 py-2 text-white-50 mx-auto" style="background-color: #1a1a1a;">
                            {{ $msg->content }}
                        </span>
                    </div>
                @elseif($msg->system_type === 'proposal')
                    <!-- TARJETA DE PROPUESTA -->
                    <div class="card bg-black border border-primary my-4 shadow-lg">
                        <div class="card-header bg-black border-bottom border-primary text-center p-3 text-primary stencil-text fw-bold">
                            NUEVA PROPUESTA DE TRUEQUE
                        </div>
                        <div class="card-body p-4">
                            <div class="row align-items-center text-center">
                                <div class="col-5">
                                    <p class="font-monospace text-white-50 small mb-2">OFRECE</p>
                                    @if($msg->trueque->oferta->images->isNotEmpty())
                                        <img src="{{ Storage::url($msg->trueque->oferta->images->first()->image_path) }}" class="img-fluid border border-secondary" style="height: 150px; object-fit: cover; width: 100%;">
                                    @endif
                                    <p class="font-monospace text-white mt-2 mb-0">{{ $msg->trueque->oferta->equipo }}</p>
                                </div>
                                <div class="col-2">
                                    <span class="material-symbols-outlined text-primary fs-1">change_circle</span>
                                </div>
                                <div class="col-5">
                                    <p class="font-monospace text-white-50 small mb-2">PIDE</p>
                                    @if($msg->trueque->objetivo->images->isNotEmpty())
                                        <img src="{{ Storage::url($msg->trueque->objetivo->images->first()->image_path) }}" class="img-fluid border border-secondary" style="height: 150px; object-fit: cover; width: 100%;">
                                    @endif
                                    <p class="font-monospace text-white mt-2 mb-0">{{ $msg->trueque->objetivo->equipo }}</p>
                                </div>
                            </div>
                            
                            @if($msg->trueque->estado === 'pendiente' && $msg->trueque->receptor_id === auth()->id())
                                <div class="mt-4 pt-3 border-top border-secondary d-flex flex-column flex-md-row justify-content-center gap-2 md:gap-3">
                                    <form action="{{ route('trueques.reject', $msg->trueque->id) }}" method="POST" class="w-100">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger fw-bold font-monospace px-4 py-2 rounded-0 w-100">RECHAZAR</button>
                                    </form>
                                    <form action="{{ route('trueques.accept', $msg->trueque->id) }}" method="POST" class="w-100">
                                        @csrf
                                        <button type="submit" class="btn fw-bold font-monospace px-4 py-2 rounded-0 w-100" style="background-color: var(--primary-color); color: #000;">ACEPTAR PROPUESTA</button>
                                    </form>
                                </div>
                            @elseif($msg->trueque->estado === 'aceptado')
                                <div class="mt-4 pt-3 border-top border-secondary text-center">
                                    <span class="text-success fw-bold font-monospace">PROPUESTA ACEPTADA</span>
                                </div>
                            @elseif($msg->trueque->estado === 'rechazado')
                                <div class="mt-4 pt-3 border-top border-secondary text-center">
                                    <span class="text-danger fw-bold font-monospace">PROPUESTA RECHAZADA</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <!-- MENSAJE NORMAL -->
                    @if($msg->user_id === auth()->id())
                        <!-- Mi mensaje (derecha) -->
                        <div class="d-flex justify-content-end mb-2">
                            <div class="p-3 shadow-sm" style="background-color: var(--primary-color); color: #000; border-radius: 15px 15px 0 15px; max-width: 75%;">
                                <p class="mb-0 font-monospace">{{ $msg->content }}</p>
                            </div>
                        </div>
                    @else
                        <!-- Mensaje de otro (izquierda) -->
                        <div class="d-flex justify-content-start mb-2">
                            <div class="p-3 shadow-sm" style="background-color: #222; border: 1px solid #333; color: white; border-radius: 15px 15px 15px 0; max-width: 75%;">
                                <p class="mb-0 font-monospace">{{ $msg->content }}</p>
                            </div>
                        </div>
                    @endif
                @endif
            @endforeach
        </div>
    </div>
</section>

<!-- ZONA DE ENVÍO FIJADA ABAJO -->
<div class="fixed-bottom bg-black border-top border-secondary p-3">
    <div class="container" style="max-width: 800px;">
        <form action="{{ route('buzon.message', $chat->id) }}" method="POST" class="d-flex gap-2">
            @csrf
            <input type="text" name="content" class="form-control form-control-lg bg-dark text-white border-secondary rounded-0 font-monospace" placeholder="Escribe un mensaje..." required autocomplete="off" autofocus>
            <button type="submit" class="btn btn-lg rounded-0 px-4" style="background-color: var(--primary-color); color: #000;">
                <span class="material-symbols-outlined align-middle">send</span>
            </button>
        </form>
    </div>
</div>

<style>
    .custom-hover:hover .stencil-text, .custom-hover:hover span { color: #ccff00 !important; }
    /* Para que el scroll baje automáticamente (requeriría JS, pero podemos simular poniendo al revés o usando flex-column-reverse, aunque esto ya funciona) */
    html, body {
        scroll-behavior: auto !important; /* Quitar smooth localmente si preferimos que baje de golpe */
    }
</style>
<script>
    // Hacer scroll down al cargar la página para ver el último mensaje
    window.scrollTo(0, document.body.scrollHeight);
</script>
@endsection
