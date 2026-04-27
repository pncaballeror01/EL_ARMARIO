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

        {{-- Eliminado saludo y botón logout de aquí --}}
    </div>
</nav>

