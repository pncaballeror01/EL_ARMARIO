<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EL ARMARIO - Vintage Jersey Swap') }}</title>

    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Noto+Sans:wght@400;500;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#E7FF00",
                        "background-dark": "#000000",
                        "surface-dark": "#1F1F1F",
                        "text-dim": "#bcba9a",
                    },
                    fontFamily: {
                        "display": ["Space Grotesk", "sans-serif"],
                        "body": ["Noto Sans", "sans-serif"],
                        "mono": ["ui-monospace", "SFMono-Regular", "Menlo", "Monaco", "Consolas", "Liberation Mono", "Courier New", "monospace"],
                    },
                    boxShadow: {
                        "neon": "0 0 10px rgba(231, 255, 0, 0.5)",
                    },
                    animation: {
                        'marquee': 'marquee 25s linear infinite',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        marquee: {
                            '0%': { transform: 'translateX(0%)' },
                            '100%': { transform: 'translateX(-100%)' },
                        }
                    }
                },
            },
        }
    </script>
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .stencil-text { text-transform: uppercase; letter-spacing: -0.02em; }
        .bg-stripes {
            background-image: repeating-linear-gradient(
                45deg,
                rgba(255, 255, 255, 0.03),
                rgba(255, 255, 255, 0.03) 10px,
                transparent 10px,
                transparent 20px
            );
        }
        .bg-grid-metal {
            background-color: #0a0a0a;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            background-size: 40px 40px;
        }
    </style>
</head>
<body class="bg-background-dark text-white font-display overflow-x-hidden selection:bg-primary selection:text-black">

<header class="fixed top-0 left-0 right-0 z-50 bg-black/90 backdrop-blur-md border-b border-[#333]">
    <div class="max-w-[1440px] mx-auto px-4 md:px-6 h-16 md:h-20 relative flex items-center justify-between">
        <a href="{{ url('/') }}" onclick="showSpinnerAndReload(event)" class="flex items-center gap-2 group cursor-pointer z-50">
            <span class="material-symbols-outlined text-primary text-2xl md:text-3xl transition-transform duration-300 group-hover:scale-110">checkroom</span>
            <h1 class="text-xl md:text-2xl font-bold tracking-tighter stencil-text text-white group-hover:text-primary transition-colors duration-300">EL ARMARIO</h1>
        </a>

        <div class="hidden lg:flex items-center gap-3 xl:gap-4">
            @if (Route::has('login'))
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="h-10 px-6 border-2 border-[#E7FF00] hover:bg-white hover:text-black hover:border-white text-sm font-mono font-bold uppercase tracking-wider transition-colors text-[#E7FF00] bg-black/40 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[1.1rem]">security</span>
                            PANEL ADMIN
                        </a>
                    @else
                        <a href="{{ route('buzon.index') }}" class="h-10 px-6 border-2 border-[#333] hover:border-white text-sm font-mono font-bold uppercase tracking-wider transition-colors text-white bg-black/40 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[1.1rem]">inbox</span>
                            BUZÓN
                            @if(auth()->user()->unreadMessagesCount() > 0)
                                <span class="bg-red-600 text-white rounded-full px-2 py-0.5 text-[0.65rem] leading-none">{{ auth()->user()->unreadMessagesCount() }}</span>
                            @endif
                        </a>
                        <a href="{{ url('/armario') }}" class="h-10 px-6 border-2 border-primary text-black bg-primary hover:bg-transparent hover:text-primary text-sm font-mono font-bold uppercase tracking-wider transition-all shadow-neon flex items-center gap-2">
                            <span class="material-symbols-outlined text-[1.1rem]">checkroom</span>
                            MI ARMARIO
                        </a>
                    @endif
                    <div class="h-10 px-4 border-2 border-[#333] text-text-dim flex items-center justify-center font-mono text-sm tracking-wider bg-black/40">
                        ¡HOLA, <span class="text-white font-bold ml-1.5">{{ strtoupper(auth()->user()->nombre_usuario) }}</span>!
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="h-10 px-3 xl:px-6 border-2 border-[#ff0055] text-[#ff0055] hover:bg-[#ff0055] hover:text-white hover:border-[#ff0055] text-[10px] xl:text-sm font-mono font-bold uppercase tracking-wider transition-all flex items-center gap-1 xl:gap-2">
                            <span class="material-symbols-outlined text-[1.1rem]">logout</span>
                            SALIR
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="h-10 px-6 border-2 border-[#333] hover:border-white text-sm font-mono font-bold uppercase tracking-wider transition-colors text-white bg-black/40 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[1.1rem]">login</span>
                        INICIAR SESIÓN
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="h-10 px-6 bg-primary hover:bg-white text-black font-black uppercase tracking-wider transition-all shadow-neon hover:shadow-none border-2 border-primary hover:border-white text-sm flex items-center gap-2">
                            <span class="material-symbols-outlined text-[1.1rem]">person_add</span>
                            REGÍSTRATE
                        </a>
                    @endif
                @endauth
            @endif
        </div>

        <button id="menu-btn" class="lg:hidden text-white p-2 z-[70]">
            <span class="material-symbols-outlined text-3xl">menu</span>
        </button>
    </div>
</header>

    <div id="mobile-menu" class="fixed top-16 md:top-20 left-0 w-full bg-black/90 backdrop-blur-2xl z-[40] flex flex-col items-center justify-start pt-8 pb-10 opacity-0 pointer-events-none transition-all duration-500 scale-95 origin-top lg:hidden border-b border-[#333] shadow-[0_30px_60px_rgba(0,0,0,0.8)]">
        <div class="flex flex-col items-center gap-4 w-full px-6 sm:px-10">
            @if (Route::has('login'))
                @auth
                    <div class="flex flex-col items-center mb-4">
                        <div class="text-text-dim font-mono text-[0.6rem] tracking-[0.3em] uppercase opacity-40 mb-2">Sesión activa</div>
                        <div class="text-white font-bold text-3xl tracking-tighter stencil-text">
                            {{ strtoupper(auth()->user()->nombre_usuario) }}
                        </div>
                    </div>

                    <div class="w-full max-w-xs h-px bg-white/5 mb-6"></div>

                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-center gap-3 w-full max-w-xs h-14 border-2 border-primary text-primary font-black uppercase tracking-widest text-sm hover:bg-primary hover:text-black transition-all">
                            <span class="material-symbols-outlined">security</span>
                            PANEL ADMIN
                        </a>
                    @else
                        <a href="{{ url('/armario') }}" class="flex items-center justify-center gap-3 w-full max-w-xs h-14 bg-primary text-black font-black uppercase tracking-widest text-sm shadow-[0_0_30px_rgba(231,255,0,0.2)]">
                            <span class="material-symbols-outlined">checkroom</span>
                            MI ARMARIO
                        </a>
                        <a href="{{ route('buzon.index') }}" class="flex items-center justify-center gap-3 w-full max-w-xs h-14 border-2 border-[#1a1a1a] text-sm font-mono font-bold uppercase tracking-widest text-white hover:border-primary transition-all">
                            <span class="material-symbols-outlined">inbox</span>
                            BUZÓN
                            @if(auth()->user()->unreadMessagesCount() > 0)
                                <span class="bg-red-600 text-white rounded-full px-2 py-0.5 text-[0.65rem] animate-pulse">{{ auth()->user()->unreadMessagesCount() }}</span>
                            @endif
                        </a>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}" class="w-full max-w-xs">
                        @csrf
                        <button type="submit" class="flex justify-center items-center gap-3 w-full h-14 border-2 border-red-500/30 text-sm font-mono font-bold uppercase tracking-widest text-red-500 hover:text-white hover:bg-red-500 hover:border-red-500 transition-all">
                            <span class="material-symbols-outlined">logout</span>
                            CERRAR SESIÓN
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="flex items-center justify-center gap-3 w-full max-w-xs h-14 border-2 border-[#1a1a1a] text-sm font-mono font-bold uppercase tracking-widest text-white">
                        <span class="material-symbols-outlined">login</span>
                        INICIAR SESIÓN
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="flex items-center justify-center gap-3 w-full max-w-xs h-14 bg-primary text-black font-black uppercase tracking-widest text-sm">
                            <span class="material-symbols-outlined">person_add</span>
                            REGÍSTRATE
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
<section class="relative min-h-[90vh] md:min-h-screen flex flex-col pt-16 md:pt-20">
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent z-10"></div>
        <img src="{{ asset('img/fondo_Landing.png') }}"
             alt="Hero"
             class="absolute inset-0 w-full h-full"
             style="object-fit: cover; object-position: 50% 18%;">
    </div>

    <div class="absolute top-24 left-1/2 -translate-x-1/2 md:translate-x-0 md:left-auto md:top-28 md:right-6 z-20 w-max">
        <div class="font-mono text-[10px] md:text-xs font-bold text-white/80 border border-white/20 bg-black/50 backdrop-blur px-3 py-1 uppercase tracking-widest">
            EST. 2024 /// MADRID
        </div>
    </div>

    <div class="relative z-20 flex-1 flex flex-col justify-center items-center px-4 py-12 md:py-20 text-center max-w-5xl mx-auto mt-10 md:mt-0">
        <h2 class="text-5xl md:text-6xl lg:text-8xl font-black leading-[0.9] tracking-tighter mb-6 md:mb-8 text-white drop-shadow-2xl">
            VISTE LA<br/>
            <span class="text-transparent bg-clip-text bg-gradient-to-b from-white to-gray-400">HISTORIA.</span><br/>
            DOMINA LA<br/>
            <span class="text-primary">CALLE.</span>
        </h2>
        
    </div>

    <div class="relative z-20 bg-primary text-black overflow-hidden py-3 border-y-2 border-black flex whitespace-nowrap">
        @php
            $marqueeItems = $equipos->isNotEmpty() ? $equipos : collect(['VINTAGE KITS', 'TRADING OPEN', 'SWAP OR DROP', 'AUTHENTIC GEAR']);
            // Repetimos los items si hay pocos para que llenen la pantalla
            if($marqueeItems->count() < 10) {
                $marqueeItems = $marqueeItems->concat($marqueeItems)->concat($marqueeItems);
            }
        @endphp
        @foreach([1,2] as $_)
        <div class="flex shrink-0 items-center animate-marquee gap-10 pr-10">
            @foreach($marqueeItems as $equipo)
                <span class="flex items-center gap-2 font-mono font-bold text-xs md:text-sm tracking-widest uppercase">
                    <span class="material-symbols-outlined text-base">checkroom</span>
                    {{ $equipo }}
                </span>
                <span class="opacity-40">///</span>
            @endforeach
        </div>
        @endforeach
    </div>
</section>

<!-- SEARCH SECTION -->
<div class="relative @guest overflow-hidden max-h-[850px] @endguest border-b border-[#333]">
    @guest
    <div class="absolute inset-0 z-40 flex flex-col items-center pt-24 bg-gradient-to-b from-black/0 via-black/90 to-background-dark">
        <div class="text-center flex flex-col items-center mx-4 max-w-2xl border border-[#333] bg-[#0a0a0a] p-8 md:p-12 shadow-[0_0_30px_rgba(231,255,0,0.15)] mt-10 relative z-10">
            <span class="material-symbols-outlined text-primary text-6xl mb-4">lock</span>
            <h3 class="text-4xl md:text-5xl font-black italic tracking-tighter transform -skew-x-6 text-white stencil-text mb-4">ACCESO <span class="text-primary">RESTRINGIDO</span></h3>
            <p class="font-mono text-[#a0a0a0] mb-8 text-sm md:text-base leading-relaxed">El protocolo de búsqueda, el catálogo completo y todos los intercambios son exclusivos para los miembros del club. Identifícate para entrar en El Armario.</p>
            
            <div class="flex flex-col sm:flex-row gap-4 w-full justify-center">
                <a href="{{ route('login') }}" class="group relative flex items-center justify-center border-2 border-[#333] hover:border-white bg-black text-white font-mono font-bold text-sm px-6 py-3 uppercase tracking-wide transition-colors">
                    INICIAR SESIÓN
                </a>
                <a href="{{ route('register') }}" class="group relative flex items-center justify-center bg-primary text-black font-black text-sm px-6 py-3 uppercase tracking-wide border-2 border-primary hover:bg-white hover:text-black transition-all shadow-neon">
                    ÚNETE AL CLUB
                </a>
            </div>
        </div>
        <div class="flex-1 w-full bg-background-dark absolute inset-x-0 bottom-0 h-1/2 -z-10"></div>
    </div>
    @endguest

    <div class="@guest blur-md opacity-30 pointer-events-none select-none @endguest">
<section class="relative bg-background-dark py-12 px-4 z-30">
    <div class="w-full max-w-4xl mx-auto bg-black border-2 border-primary p-4 md:p-6 shadow-[0_0_20px_rgba(231,255,0,0.2)] text-left relative">
        <h4 class="text-primary stencil-text text-xl md:text-2xl mb-4 text-center">/// PROTOCOLO DE BÚSQUEDA</h4>
        <form action="{{ route('explorar') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-text-dim font-mono text-xs mb-1">EQUIPO</label>
                    <input type="text" name="equipo" class="w-full bg-[#111] border border-[#333] text-white font-mono text-sm p-3 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary" placeholder="Ej: Real Madrid">
                </div>
                <div>
                    <label class="block text-text-dim font-mono text-xs mb-1">TALLA</label>
                    <select name="talla" class="w-full bg-[#111] border border-[#333] text-white font-mono text-sm p-3 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                        <option value="">TODAS LAS TALLAS</option>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                    </select>
                </div>
                <div>
                    <label class="block text-text-dim font-mono text-xs mb-1">AÑO</label>
                    <input type="number" name="año" class="w-full bg-[#111] border border-[#333] text-white font-mono text-sm p-3 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary" placeholder="Ej: 2005">
                </div>
            </div>
            <button type="submit" class="w-full bg-primary text-black font-black font-mono text-sm uppercase py-3 hover:bg-white transition-colors tracking-widest text-center">
                INICIAR BÚSQUEDA <span class="material-symbols-outlined align-middle ml-2 text-lg">search</span>
            </button>
        </form>
    </div>
</section>

<!-- MESSI ADVERTISEMENT SECTION -->
<section class="relative bg-black py-16 px-4 md:px-12 border-b border-[#333] overflow-hidden group">
    <div class="absolute inset-0 bg-primary opacity-5 group-hover:opacity-10 transition-opacity"></div>
    <div class="max-w-[1440px] mx-auto relative z-10 flex flex-col md:flex-row shadow-[0_0_20px_rgba(231,255,0,0.05)] items-center gap-8 md:gap-16 bg-[#0a0a0a] border border-[#333] p-6 md:p-12 hover:border-primary hover:shadow-[0_0_30px_rgba(231,255,0,0.15)] transition-all duration-500">
        <div class="w-full md:w-5/12 relative flex justify-center">
            <div class="absolute inset-0 bg-primary opacity-0 group-hover:opacity-20 blur-3xl transition-all duration-700"></div>
            <!-- IMAGEN DE MESSI -->
            <img src="{{ asset('img/messipubli.jpeg') }}" alt="Leo Messi en El Armario" class="w-full max-w-sm h-auto object-cover relative z-10 transition-transform duration-700 group-hover:scale-105 border-b-4 border-primary filter contrast-[1.1]">
        </div>
        <div class="w-full md:w-7/12 flex flex-col gap-6 text-left">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-primary text-4xl transform -scale-x-100">format_quote</span>
                <span class="font-mono text-primary text-xs tracking-widest uppercase border border-primary px-2 py-1">CERTIFIED ENDORSEMENT</span>
            </div>
            <h3 class="text-4xl md:text-6xl font-black italic tracking-tighter text-white stencil-text leading-[0.9]">
                "NO ES SÓLO FÚTBOL. ES <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-white">NUESTRA HISTORIA</span>."
            </h3>
            <p class="font-mono text-[#a0a0a0] text-sm md:text-base leading-relaxed">
                El Armario cuenta con mi total apoyo. Preservar las camisetas auténticas es mantener viva la pasión y la verdadera esencia de nuestro amado deporte. El único lugar donde el patrimonio del fútbol se respeta de verdad.
            </p>
            <div class="flex items-center gap-4 mt-2 border-t border-[#333] pt-6">
                <div>
                    <h5 class="text-white font-black stencil-text text-2xl tracking-tight">LIONEL MESSI</h5>
                    <p class="text-text-dim font-mono text-xs uppercase tracking-widest mt-1">CAMPEÓN DEL MUNDO /// LEYENDA DEL FÚTBOL ABSOLUTA</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="explorar" class="relative bg-background-dark py-20 px-4 md:px-12 border-b border-[#333] overflow-hidden">
    <div class="max-w-[1440px] mx-auto">
        <div class="flex flex-col mb-10 border-b border-[#333] pb-6">
            <h3 class="text-4xl md:text-6xl font-black italic tracking-tighter transform -skew-x-6 text-white leading-none stencil-text">
                LO ÚLTIMO <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-white pr-2">DEL ARMARIO</span>
            </h3>
        </div>

        <div class="relative w-full overflow-hidden mb-4">
            @if($camisetas->isEmpty())
                <div class="text-center py-20 border-2 border-[#333] bg-surface-dark">
                    <span class="material-symbols-outlined text-gray-600 text-6xl mb-4">inventory_2</span>
                    <h3 class="text-white stencil-text text-2xl">EL ARMARIO ESTÁ VACÍO AÚN</h3>
                    <p class="text-text-dim font-mono text-sm mt-2">SÉ EL PRIMERO EN SUBIR UNA CAMISETA INTERCAMBIABLE</p>
                </div>
            @else
                <div id="jersey-carousel" class="flex overflow-x-auto snap-x snap-mandatory gap-6 pb-8 no-scrollbar" style="scroll-padding-left: 10px;">
                    @foreach($camisetas as $cam)
                    <div class="snap-start shrink-0 w-[280px] sm:w-[320px] bg-surface-dark border border-[#333] group hover:border-primary transition-colors flex flex-col relative">
                        <div class="aspect-[4/5] bg-black relative overflow-hidden">
                            @if($cam->images->isNotEmpty())
                                <img src="{{ Storage::url($cam->images->first()->image_path) }}" alt="{{ $cam->equipo }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-text-dim"><span class="material-symbols-outlined text-4xl">image_not_supported</span></div>
                            @endif
                            <div class="absolute top-3 right-3 bg-black px-2 py-1 border-2 border-primary text-primary font-mono text-xs font-bold uppercase transition-all" style="box-shadow: 0 0 10px rgba(231,255,0,0.4);">
                                DISPONIBLE
                            </div>
                        </div>
                        <div class="p-4 flex flex-col flex-1">
                            <h4 class="text-white font-mono font-bold uppercase truncate text-lg">{{ $cam->equipo }}</h4>
                            <div class="flex justify-between items-center mt-2 text-text-dim font-mono text-xs">
                                <span>TALLA: <span class="text-white">{{ $cam->talla }}</span></span>
                                <span>{{ $cam->año }}</span>
                            </div>
                            @if($cam->user)
                            <a href="{{ route('usuario.perfil', $cam->user->id_usuario) }}"
                               class="mt-2 flex items-center gap-1 font-mono text-xs no-underline transition-opacity"
                               style="color: #E7FF00; letter-spacing: 1px;"
                               onmouseover="this.style.opacity='0.7'; this.style.textDecoration='underline';"
                               onmouseout="this.style.opacity='1'; this.style.textDecoration='none';">
                                <span class="material-symbols-outlined" style="font-size: 0.85rem;">person</span>
                                {{ $cam->user->nombre_usuario }}
                            </a>
                            @endif
                            <a href="{{ route('intercambio.create', ['id_camiseta' => $cam->id]) }}" class="mt-4 w-full block text-center border border-[#333] hover:border-primary text-white hover:text-black hover:bg-primary font-mono font-bold py-2 text-sm transition-colors uppercase">
                                HAGAMOS TRATO
                            </a>
                        </div>
                    </div>
                    @endforeach

                    {{-- Tarjeta CTA al catálogo completo --}}
                    <a href="{{ route('explorar') }}" class="snap-start shrink-0 w-[280px] sm:w-[320px] bg-primary border-2 border-primary group hover:bg-white transition-all flex flex-col items-center justify-center relative shadow-[0_0_30px_rgba(231,255,0,0.3)] hover:shadow-[0_0_40px_rgba(255,255,255,0.4)]">
                        <span class="material-symbols-outlined text-7xl text-black mb-4 group-hover:scale-110 transition-transform duration-300">storefront</span>
                        <h4 class="text-black font-black stencil-text text-2xl text-center leading-tight px-4">VER TODO EL ARMARIO</h4>
                        <p class="font-mono text-black/60 text-xs mt-3 uppercase tracking-widest">CATÁLOGO COMPLETO</p>
                        <div class="mt-6 w-10 h-10 border-2 border-black flex items-center justify-center group-hover:bg-black group-hover:text-white transition-all">
                            <span class="material-symbols-outlined text-xl">arrow_forward</span>
                        </div>
                    </a>
                </div>

                <!-- Botones de navegación debajo -->
                <div class="flex justify-center gap-4 mt-4 mb-8">
                    <button onclick="moveCarousel(-1)" class="w-14 h-14 bg-primary text-black flex items-center justify-center hover:bg-white hover:scale-105 transition-all shadow-[0_0_20px_rgba(231,255,0,0.5)]">
                        <span class="material-symbols-outlined text-3xl font-bold">chevron_left</span>
                    </button>
                    <button onclick="moveCarousel(1)" class="w-14 h-14 bg-primary text-black flex items-center justify-center hover:bg-white hover:scale-105 transition-all shadow-[0_0_20px_rgba(231,255,0,0.5)]">
                        <span class="material-symbols-outlined text-3xl font-bold">chevron_right</span>
                    </button>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- ORIGINS SECTION -->
<section class="relative bg-black py-20 px-4 md:px-12 border-b border-[#333] overflow-hidden">
    <!-- Efecto de fondo sutil -->
    <div class="absolute inset-0 bg-primary opacity-5 group-hover:opacity-10 transition-opacity"></div>
    
    <div class="max-w-5xl mx-auto flex flex-col relative z-10 w-full">
        <div class="shadow-[0_0_20px_rgba(231,255,0,0.05)] bg-[#0a0a0a] border border-[#333] p-8 md:p-16 hover:border-primary hover:shadow-[0_0_30px_rgba(231,255,0,0.15)] transition-all duration-500 group/box">
            <h3 class="text-5xl md:text-7xl font-black italic tracking-tighter transform -skew-x-6 text-white stencil-text mb-4 group-hover/box:text-primary transition-colors duration-500">
                NUESTROS <span class="text-white">ORÍGENES</span>
            </h3>
            <p class="text-primary font-mono text-xs uppercase tracking-widest mb-8">/// EST. 2024 /// EL ORIGEN</p>
            
            <div class="font-mono text-[#a0a0a0] text-sm md:text-base space-y-6 leading-relaxed border-l-2 border-primary pl-6">
                <p>
                    <strong class="text-white">EL ARMARIO</strong> nació en las calles frente a una realidad frustrante: la especulación desmedida estaba destruyendo la verdadera cultura de las camisetas vintage. Las joyas más preciadas quedaban bloqueadas en armarios acumulando polvo debido a precios prohibitivos.
                </p>
                <p>
                    Nos dimos cuenta de una necesidad vital: <strong>había que mover y dinamizar el mercado de una forma distinta</strong>. No queríamos otra tienda con sobreprecios, queríamos una revolución basada en el trato directo. La solución era clara: volver a nuestros orígenes mediante el <strong>intercambio puro</strong>.
                </p>
                <p class="text-primary font-bold inline-block border border-primary px-3 py-1">
                    Aquí la moneda de cambio no es el dinero, es tu propia camiseta.
                </p>
                <p>
                    Creamos un santuario donde coleccionistas de verdad pudieran hablar el mismo idioma. Tú tienes algo que yo busco, yo tengo algo que tú quieres. Sin intermediarios que inflen los precios, sin tarifas ocultas, solo cultura, pasión y la historia que llevas puesta.
                </p>
            </div>
            
            <div class="mt-10 flex gap-4">
                <div class="w-16 h-1 bg-primary"></div>
                <div class="w-4 h-1 bg-white"></div>
                <div class="w-4 h-1 bg-white"></div>
            </div>
        </div>
    </div>
</section>
    </div> <!-- /fin blur wrapper -->
</div> <!-- /fin restricted wrapper -->

<footer class="bg-grid-metal border-t border-[#333] py-16 px-6 relative">
    <div class="max-w-[1440px] mx-auto flex flex-col md:flex-row justify-between items-start gap-12">
        <div class="flex flex-col gap-4">
            <a href="#" class="flex items-center gap-2 group">
                <span class="material-symbols-outlined text-primary text-2xl group-hover:scale-110 transition-transform">checkroom</span>
                <h5 class="text-xl font-bold stencil-text text-transparent bg-clip-text bg-gradient-to-r from-primary to-white">EL ARMARIO</h5>
            </a>
            <p class="text-gray-500 font-mono text-sm max-w-xs">El marketplace underground definitivo para leyendas del fútbol.</p>
        </div>
        <div class="flex gap-16 font-mono text-sm">
            <div class="flex flex-col gap-3">
                <span class="text-white font-bold uppercase">Redes</span>
                <a class="text-gray-500 hover:text-primary transition-colors" href="#">Instagram</a>
                <a class="text-gray-500 hover:text-primary transition-colors" href="#">Twitter / X</a>
                <a class="text-gray-500 hover:text-primary transition-colors" href="#">TikTok</a>
            </div>
            <div class="flex flex-col gap-3">
                <span class="text-white font-bold uppercase">Legal</span>
                <a class="text-gray-500 hover:text-primary transition-colors" href="#">Términos</a>
                <a class="text-gray-500 hover:text-primary transition-colors" href="#">Contacto</a>
            </div>
        </div>
    </div>
    <div class="max-w-[1440px] mx-auto mt-16 pt-8 border-t border-[#333] flex flex-col md:flex-row justify-between items-center text-xs font-mono text-gray-600 gap-4">
        <p>© {{ date('Y') }} EL ARMARIO TRADING CO.</p>
        <span>LOGROÑO // LA RIOJA</span>
    </div>
</footer>

<script>
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    let isMenuOpen = false;

    function moveCarousel(direction) {
        const carousel = document.getElementById('jersey-carousel');
        if (!carousel) return;
        const cardWidth = carousel.querySelector('div')?.offsetWidth || 320;
        carousel.scrollBy({ left: direction * (cardWidth + 24), behavior: 'smooth' });
    }

    menuBtn.addEventListener('click', () => {
        isMenuOpen = !isMenuOpen;
        if(isMenuOpen) {
            mobileMenu.classList.remove('opacity-0', 'pointer-events-none', 'scale-95');
            mobileMenu.classList.add('opacity-100', 'scale-100');
            menuBtn.innerHTML = '<span class="material-symbols-outlined text-3xl">close</span>';
            document.body.style.overflow = 'hidden';
        } else {
            mobileMenu.classList.add('opacity-0', 'pointer-events-none', 'scale-95');
            mobileMenu.classList.remove('opacity-100', 'scale-100');
            menuBtn.innerHTML = '<span class="material-symbols-outlined text-3xl">menu</span>';
            document.body.style.overflow = '';
        }
    });

    function showSpinnerAndReload(e) {
        if(e) e.preventDefault();
        const spinner = document.getElementById('global-spinner');
        if(spinner) {
            spinner.classList.remove('opacity-0', 'pointer-events-none');
        }
        
        // Simular un pequeño tiempo de carga visual antes de recargar
        setTimeout(() => {
            window.location.href = "{{ url('/') }}";
        }, 600);
    }
</script>

<!-- GLOBAL SPINNER FOR LOGO CLICK -->
<div id="global-spinner" class="fixed inset-0 bg-black z-[100] flex flex-col items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="relative flex items-center justify-center">
        <div class="w-20 h-20 border-4 border-[#333] border-t-primary rounded-full animate-spin"></div>
        <span class="material-symbols-outlined text-primary text-3xl absolute animate-pulse">checkroom</span>
    </div>
    <h2 class="mt-6 text-white font-black stencil-text tracking-widest text-xl animate-pulse">EL ARMARIO</h2>
</div>

</body>
</html>
