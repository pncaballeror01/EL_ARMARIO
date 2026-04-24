<nav class="navbar fixed-top bg-black border-bottom border-secondary py-3" style="z-index: 1000;">
    <div class="container-fluid px-md-5 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            {{-- Botón hamburguesa (solo visible en móvil/tablet) --}}
            <button class="sidebar-toggle d-lg-none" id="sidebarToggleBtn" onclick="toggleSidebar()">
                <span class="material-symbols-outlined" style="font-size: 1.2rem;">menu</span>
                MENÚ
            </button>
            <a class="navbar-brand d-flex align-items-center text-white" href="{{ route('admin.dashboard') }}">
                <span class="material-symbols-outlined text-primary me-2" style="font-size: 1.8rem;">checkroom</span>
                <span class="stencil-text h4 mb-0" style="letter-spacing: 1px;">EL ARMARIO <span class="text-primary">ADMIN</span></span>
            </a>
        </div>

        <div class="d-flex align-items-center gap-3">
            <div class="d-none d-sm-flex align-items-center px-3 border border-secondary font-monospace small text-white" style="height: 2.5rem; background-color: rgba(0,0,0,0.4);">
                ¡HOLA, <span class="fw-bold ms-1 text-uppercase">{{ Auth::user()->nombre_usuario ?? 'ADMIN' }}</span>!
            </div>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm rounded-0 fw-bold d-flex align-items-center gap-1" style="font-family: monospace; letter-spacing: 0.05em; height: 2.5rem; padding: 0 1rem;">
                    <span class="material-symbols-outlined" style="font-size: 1.1rem;">logout</span>
                    SALIR
                </button>
            </form>
        </div>
    </div>
</nav>

