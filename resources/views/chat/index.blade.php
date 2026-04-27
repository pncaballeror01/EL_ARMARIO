@extends('layouts.app')

@section('content')
<nav class="bg-black py-3 border-bottom border-secondary">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ url('/') }}" class="text-decoration-none d-flex align-items-center text-white custom-hover">
            <span class="material-symbols-outlined me-1 md:me-2" style="color: #ccff00">arrow_back</span>
            <span class="material-symbols-outlined me-1 md:me-2 d-none d-sm-block" style="color: #ccff00">checkroom</span>
            <span class="stencil-text h5 md:h4 mb-0 m-0">EL ARMARIO</span>
        </a>
    </div>
</nav>

<section class="py-5 bg-grid-metal" style="background-color: #050505; min-height: 85vh;">
    <div class="container">
        
        <div class="d-flex align-items-center gap-2 md:gap-3 mb-4 md:mb-5">
            <span class="material-symbols-outlined text-primary text-4xl md:text-[3rem]">inbox</span>
            <h2 class="stencil-text text-3xl md:text-5xl text-white mb-0">TU <span class="text-primary">BUZÓN</span></h2>
        </div>

        <div class="row">
            <div class="col-12 col-md-10 col-lg-8 mx-auto px-2 md:px-0">
                <div class="d-flex flex-column gap-3">
                    @forelse($chats as $chat)
                        @php
                            $lastMsg = $chat->messages->first();
                            $other = $chat->otherUser();
                            $unreadCount = $chat->messages->where('user_id', '!=', auth()->id())->where('is_read', false)->count();
                        @endphp
                        <div class="position-relative bg-[#111] border border-[#333] hover:border-primary transition-all duration-300 group shadow-lg">
                            <a href="{{ route('buzon.show', $chat->id) }}" class="text-decoration-none d-block p-3 p-md-4">
                                <div class="d-flex align-items-center gap-3 gap-md-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-[45px] h-[45px] md:w-[65px] md:h-[65px] rounded-full d-flex align-items-center justify-content-center bg-black border-2 border-[#333] group-hover:border-primary transition-colors">
                                            <span class="material-symbols-outlined text-[#555] group-hover:text-primary fs-5 md:fs-3 transition-colors">person</span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 min-width-0">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h5 class="stencil-text text-white mb-0 text-sm md:text-lg tracking-tight">
                                                {{ strtoupper($other->nombre_usuario) }}
                                                @if($unreadCount > 0)
                                                    <span class="bg-primary text-black ms-2 px-2 py-0.5 font-black text-[0.6rem] uppercase">{{ $unreadCount }}</span>
                                                @endif
                                            </h5>
                                            @if($lastMsg)
                                                <small class="font-mono text-[0.65rem] text-text-dim opacity-50">{{ $lastMsg->created_at->diffForHumans() }}</small>
                                            @endif
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <p class="font-mono text-[0.75rem] md:text-sm text-secondary mb-0 text-truncate opacity-80">
                                                @if($lastMsg)
                                                    @if($lastMsg->system_type === 'proposal')
                                                        <span class="text-primary fw-bold">PROPUESTA RECIBIDA</span>
                                                    @elseif($lastMsg->system_type === 'info')
                                                        <i class="opacity-50">{{ $lastMsg->content }}</i>
                                                    @else
                                                        {{ $lastMsg->content }}
                                                    @endif
                                                @else
                                                    <span class="opacity-30 italic">Sin mensajes todavía</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 d-none d-sm-block">
                                        <span class="material-symbols-outlined text-[#333] group-hover:text-primary transition-all group-hover:translate-x-1">arrow_forward_ios</span>
                                    </div>
                                </div>
                            </a>
                            
                            <div class="position-absolute top-2 right-2 md:top-4 md:right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                                <form action="{{ route('buzon.destroy', $chat->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta conversación?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 text-red-500/50 hover:text-red-500 transition-colors bg-transparent border-0">
                                        <span class="material-symbols-outlined text-sm md:text-lg">delete</span>
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
