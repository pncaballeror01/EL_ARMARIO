@extends('layouts.app')

@section('content')
<nav class="bg-black py-3 border-bottom border-secondary">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ url('/') }}" class="text-decoration-none d-flex align-items-center text-white custom-hover">
            <span class="material-symbols-outlined me-2" style="color: #ccff00">arrow_back</span>
            <span class="material-symbols-outlined me-2" style="color: #ccff00">checkroom</span>
            <span class="stencil-text h4 mb-0">EL ARMARIO</span>
        </a>
    </div>
</nav>

<section class="py-5 bg-grid-metal" style="background-color: #050505; min-height: 85vh;">
    <div class="container">
        
        <div class="d-flex align-items-center gap-3 mb-5">
            <span class="material-symbols-outlined" style="font-size: 3rem; color: var(--primary-color);">inbox</span>
            <h2 class="stencil-text display-5 text-white mb-0">TU <span class="text-primary">BUZÓN</span></h2>
        </div>

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="d-flex flex-column gap-3">
                    @forelse($chats as $chat)
                        @php
                            $lastMsg = $chat->messages->first(); // Ya viene ordenado latest()
                            $other = $chat->otherUser();
                            $unreadCount = $chat->messages->where('user_id', '!=', auth()->id())->where('is_read', false)->count();
                        @endphp
                        <div class="position-relative bg-black border border-secondary item-grial-interactive" style="transition: all 0.3s;">
                            <a href="{{ route('buzon.show', $chat->id) }}" class="text-decoration-none d-block p-4">
                                <div class="d-flex align-items-center gap-4">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background-color: #222; border: 2px solid var(--primary-color);">
                                        <span class="material-symbols-outlined text-primary fs-2">person</span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h5 class="stencil-text text-white mb-0 fs-4">
                                                {{ strtoupper($other->nombre_usuario) }}
                                                @if($unreadCount > 0)
                                                    <span class="badge bg-danger ms-2 align-middle font-monospace" style="font-size: 0.6rem; vertical-align: text-top;">{{ $unreadCount }} NUEVOS</span>
                                                @endif
                                            </h5>
                                            @if($lastMsg)
                                                <small class="font-monospace text-muted">{{ $lastMsg->created_at->diffForHumans() }}</small>
                                            @endif
                                        </div>
                                        <p class="font-monospace text-secondary mb-0 text-truncate" style="max-width: 80%;">
                                            @if($lastMsg)
                                                @if($lastMsg->system_type === 'proposal')
                                                    <span class="material-symbols-outlined fs-6 align-middle text-primary me-1">inventory_2</span> Propuesta de intercambio
                                                @elseif($lastMsg->system_type === 'info')
                                                    <span class="material-symbols-outlined fs-6 align-middle text-info me-1">info</span> {{ $lastMsg->content }}
                                                @else
                                                    {{ $lastMsg->content }}
                                                @endif
                                            @else
                                                Sin mensajes.
                                            @endif
                                        </p>
                                    </div>
                                    <div class="text-end ps-3 border-start border-secondary d-flex flex-column justify-content-center align-items-end" style="min-height: 60px;">
                                        <span class="material-symbols-outlined text-white-50 mt-auto">chevron_right</span>
                                    </div>
                                </div>
                            </a>
                            
                            <!-- Botón Eliminar fuera del <a> -->
                            <div class="position-absolute" style="top: 15px; right: 15px; z-index: 10;">
                                <form action="{{ route('buzon.destroy', $chat->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres borrar este chat? No podrás deshacerlo.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0 p-1 rounded-circle d-flex" title="Eliminar Chat">
                                        <span class="material-symbols-outlined" style="font-size: 1.2rem;">delete</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center p-5 border border-secondary" style="background-color: #1a1a1a;">
                            <span class="material-symbols-outlined mb-3 text-secondary" style="font-size: 4rem;">inbox_customize</span>
                            <h4 class="stencil-text text-white mb-3">EL BUZÓN ESTÁ VACÍO</h4>
                            <p class="font-monospace text-muted mb-0">Las conversaciones se generarán aquí cuando envíes o recibas propuestas de trueque.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        
    </div>
</section>

<style>
    .custom-hover:hover .stencil-text, .custom-hover:hover span { color: #ccff00 !important; }
</style>
@endsection
