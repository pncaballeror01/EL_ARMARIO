@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary: #E7FF00;
        --danger: #FF0055;
        --bg-darker: #050505;
        --bg-panel: #111;
        --border-color: #222;
        --text-muted: #666;
    }

    body {
        background-color: var(--bg-darker);
        color: white;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }

    /* Layout */
    .admin-layout {
        display: flex;
        min-height: calc(100vh - 90px);
        margin-top: 90px;
    }

    /* Sidebar */
    .admin-sidebar {
        width: 280px;
        min-width: 280px;
        background-color: transparent;
        border-right: 1px solid var(--border-color);
        padding: 2rem 0;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease;
    }

    .sidebar-section {
        font-family: monospace;
        color: var(--text-muted);
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        padding: 0 2rem;
        margin-bottom: 1rem;
    }

    .nav-item-admin {
        padding: 12px 2rem;
        color: white;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 15px;
        font-family: 'Space Grotesk', sans-serif;
        font-weight: bold;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
        cursor: pointer;
    }

    .nav-item-admin:hover, .nav-item-admin.active {
        background-color: #1a1a1a;
        border-left-color: var(--primary);
        color: var(--primary);
    }
    
    .nav-item-admin .material-symbols-outlined {
        font-size: 1.2rem;
    }

    /* Content Area */
    .admin-content {
        flex: 1;
        padding: 3rem;
        min-width: 0;
        background-image: 
            linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
        background-size: 50px 50px;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        margin-bottom: 4rem;
    }

    /* Tabla responsiva */
    .table-responsive-admin {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* Hamburguesa mobile */
    .sidebar-toggle {
        display: none;
        background: none;
        border: 1px solid #444;
        color: white;
        padding: 6px 10px;
        cursor: pointer;
        align-items: center;
        gap: 6px;
        font-family: monospace;
        font-size: 0.8rem;
    }

    /* RESPONSIVE */
    @media (max-width: 991px) {
        .sidebar-toggle { display: flex; }

        .admin-sidebar {
            position: fixed;
            top: 90px;
            left: 0;
            height: calc(100vh - 90px);
            z-index: 999;
            background-color: #0a0a0a;
            transform: translateX(-100%);
        }
        .admin-sidebar.open {
            transform: translateX(0);
        }
        .admin-content {
            padding: 1.5rem;
        }
        .stats-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .cards-grid {
            grid-template-columns: 1fr;
        }
        .stat-value {
            font-size: 2.5rem;
        }
    }
    @media (min-width: 992px) and (max-width: 1199px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .admin-content {
            padding: 2rem;
        }
    }

    .stat-card {
        background-color: var(--bg-panel);
        border: 1px solid var(--border-color);
        padding: 2rem;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .stat-title {
        color: var(--danger);
        font-family: monospace;
        font-weight: bold;
        font-size: 0.8rem;
        letter-spacing: 2px;
        margin-bottom: 1rem;
        text-transform: uppercase;
    }
    
    .stat-card.yellow .stat-title {
        color: var(--primary);
    }

    .stat-value {
        font-size: 4rem;
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 900;
        color: var(--danger);
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .stat-card.yellow .stat-value {
        color: var(--primary);
    }

    .bracket {
        color: var(--danger);
        font-weight: normal;
    }
    .stat-card.yellow .bracket {
        color: var(--primary);
    }

    /* Section Title */
    .section-title {
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 900;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 2rem;
    }
    .section-title::before {
        content: '#';
        color: var(--primary);
    }

    /* Cards Grid */
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
    }

    .admin-item-card {
        background-color: var(--bg-panel);
        border: 1px solid var(--border-color);
        overflow: hidden;
        transition: all 0.3s;
    }
    .admin-item-card:hover {
        border-color: #444;
        box-shadow: 0 0 20px rgba(0,0,0,0.5);
    }

    .card-img-wrapper {
        position: relative;
        height: 250px;
        background-color: #000;
    }

    .card-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .badge-new {
        position: absolute;
        top: 15px;
        left: 15px;
        background-color: var(--primary);
        color: black;
        font-family: monospace;
        font-weight: bold;
        font-size: 0.7rem;
        padding: 4px 10px;
        border-radius: 20px;
    }

    .card-info {
        padding: 1.5rem;
    }

    .item-title {
        font-family: 'Space Grotesk', sans-serif;
        font-weight: bold;
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .item-seller {
        font-family: monospace;
        color: var(--text-muted);
        font-size: 0.8rem;
        margin-bottom: 1rem;
    }
    .item-seller span {
        color: var(--primary);
    }

    .item-tags {
        display: flex;
        gap: 10px;
        margin-bottom: 1.5rem;
    }
    .tag {
        background-color: #222;
        color: #999;
        font-family: monospace;
        font-size: 0.7rem;
        padding: 4px 12px;
        border-radius: 20px;
    }

    /* Actions */
    .card-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .btn-action {
        border: none;
        padding: 10px;
        font-family: 'Space Grotesk', sans-serif;
        font-weight: bold;
        font-size: 0.8rem;
        text-transform: uppercase;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        transition: all 0.2s;
    }

    .btn-approve {
        background-color: var(--primary);
        color: black;
        box-shadow: 0 0 15px rgba(231, 255, 0, 0.2);
    }
    .btn-approve:hover {
        background-color: #f0ff33;
        box-shadow: 0 0 20px rgba(231, 255, 0, 0.5);
    }

    .btn-reject {
        background-color: transparent;
        border: 1px solid var(--border-color);
        color: var(--danger);
    }
    .btn-reject:hover {
        background-color: var(--danger);
        color: white;
    }

    /* Tables */
    .admin-table {
        width: 100%;
        border-collapse: collapse;
        font-family: monospace;
        font-size: 0.85rem;
    }
    .admin-table th {
        text-align: left;
        padding: 1rem;
        border-bottom: 2px solid #333;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .admin-table td {
        padding: 1rem;
        border-bottom: 1px solid #222;
        color: white;
        vertical-align: middle;
    }
    .admin-table tr:hover {
        background-color: #111;
    }

    .badge-status {
        padding: 4px 8px;
        font-size: 0.7rem;
        font-weight: bold;
        border-radius: 20px;
    }
    .status-pendiente { background-color: #333; color: white; }
    .status-aprobada { background-color: rgba(231, 255, 0, 0.2); color: var(--primary); }

    .tab-content {
        display: none;
    }
    .tab-content.active {
        display: block;
    }
</style>

{{-- Navbar del panel de administración --}}
@include('admin.partials.navbar')

<div class="admin-layout container-fluid px-0 w-100">
    <!-- SIDEBAR -->
    <div class="admin-sidebar border-r border-[#333]" id="adminSidebar">
        <div class="sidebar-section">Operaciones</div>
        
        <div onclick="switchTab('inicio'); closeSidebar()" id="nav-inicio" class="nav-item-admin active">
            <span class="material-symbols-outlined">dashboard</span>
            INICIO
        </div>
        <div onclick="switchTab('perfiles'); closeSidebar()" id="nav-perfiles" class="nav-item-admin">
            <span class="material-symbols-outlined">group</span>
            PERFILES
        </div>
        <div onclick="switchTab('publicaciones'); closeSidebar()" id="nav-publicaciones" class="nav-item-admin">
            <span class="material-symbols-outlined">inventory_2</span>
            PUBLICACIONES
        </div>
        <div onclick="switchTab('intercambios'); closeSidebar()" id="nav-intercambios" class="nav-item-admin">
            <span class="material-symbols-outlined">sync_alt</span>
            INTERCAMBIOS
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="admin-content">
        @if(session('success'))
            <div class="alert alert-success border-0 rounded-0 font-monospace mb-4" style="background-color: var(--primary); color: black;">
                > {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger border-0 rounded-0 font-monospace mb-4" style="background-color: var(--danger); color: white;">
                > {{ session('error') }}
            </div>
        @endif

        <!-- TAB: INICIO -->
        <div id="tab-inicio" class="tab-content active">
            <div class="section-title">RESUMEN DEL SISTEMA</div>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-title">PERFILES CREADOS</div>
                    <div class="stat-value">
                        <span class="bracket">[</span>
                        <span class="material-symbols-outlined" style="font-size: 3rem;">group</span>
                        {{ str_pad($totalUsuarios, 2, '0', STR_PAD_LEFT) }}
                        <span class="bracket">]</span>
                    </div>
                </div>

                <div class="stat-card yellow">
                    <div class="stat-title">PUBLICACIONES TOTALES</div>
                    <div class="stat-value">
                        <span class="bracket">[</span>
                        <span class="material-symbols-outlined" style="font-size: 3rem;">checkroom</span>
                        {{ str_pad($totalPublicaciones, 2, '0', STR_PAD_LEFT) }}
                        <span class="bracket">]</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-title">NUM. INTERCAMBIOS</div>
                    <div class="stat-value">
                        <span class="bracket">[</span>
                        <span class="material-symbols-outlined" style="font-size: 3rem;">sync_alt</span>
                        {{ str_pad($totalIntercambios, 2, '0', STR_PAD_LEFT) }}
                        <span class="bracket">]</span>
                    </div>
                </div>
            </div>

            <!-- PENDIENTES -->
            <div class="section-title text-danger mt-5 mb-3 border-b border-[#333] pb-2">VAR: PENDIENTES DE APROBACIÓN ({{ $pendientes->count() }})</div>
            
            @if($pendientes->count() == 0)
                <div class="w-100 p-5 text-center mb-5" style="border: 1px dashed var(--border-color);">
                    <span class="material-symbols-outlined text-muted" style="font-size: 3rem; margin-bottom: 1rem;">drafts</span>
                    <h5 class="font-monospace text-muted">Bandeja de moderación limpia.</h5>
                </div>
            @else
                <div class="cards-grid mb-5">
                    @foreach($pendientes as $item)
                        <div class="admin-item-card">
                            <div class="card-img-wrapper" style="cursor: pointer;" onclick="window.open('{{ route('camisetas.show', $item) }}', '_blank')">
                                <div class="badge-new">REVISIÓN</div>
                                @if($item->images->isNotEmpty())
                                    <img src="{{ Storage::url($item->images->first()->image_path) }}" alt="Preview">
                                @else
                                    <div class="w-100 h-100 d-flex justify-content-center align-items-center text-muted border-secondary border">Sin imagen</div>
                                @endif
                            </div>
                            <div class="card-info">
                                <div class="item-title">{{ mb_strtoupper($item->equipo) }}</div>
                                <div class="item-seller">
                                    Vendedor: <span><a href="{{ route('usuario.perfil', $item->user->id_usuario) }}" target="_blank" style="color: var(--primary); text-decoration: none;">{{ '@' . $item->user->nombre_usuario }}</a></span>
                                </div>
                                
                                <div class="card-actions mt-3 pt-3 border-top border-dark">
                                    <form action="{{ route('admin.aprobar', $item->id) }}" method="POST" class="m-0 p-0">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn-action w-100 btn-approve">
                                            <span class="material-symbols-outlined" style="font-size: 1rem;">check</span> APROBAR
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.rechazar', $item->id) }}" method="POST" class="m-0 p-0" onsubmit="return confirm('¿Rechazar y borrar esta pieza permanentemente?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn-action w-100 btn-reject">
                                            <span class="material-symbols-outlined" style="font-size: 1rem;">close</span> RECHAZAR
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- TAB: PERFILES -->
        <div id="tab-perfiles" class="tab-content">
            <div class="section-title">CONTROL DE USUARIOS</div>
            <div class="bg-panel border border-[#333] p-0" style="background-color: var(--bg-panel);">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>USUARIO</th>
                            <th>REGISTRO</th>
                            <th>TRUEQUES CORONADOS</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $user)
                        <tr>
                            <td>#{{ $user->id_usuario }}</td>
                            <td>
                                <a href="{{ route('usuario.perfil', $user->id_usuario) }}" target="_blank" class="text-primary text-decoration-none fw-bold hover:underline">
                                    {{ '@' . $user->nombre_usuario }}
                                </a>
                                @if($user->rol_id == 2) <span class="badge bg-warning text-dark ms-2">ADMIN</span> @endif
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td>{{ $user->trueques_exitosos ?? 0 }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.editUser', $user->id_usuario) }}" class="btn btn-sm btn-outline-primary font-monospace rounded-0 border-primary text-primary hover:bg-primary hover:text-black">
                                        EDITAR
                                    </a>
                                    <form action="{{ route('admin.destroyUser', $user->id_usuario) }}" method="POST" onsubmit="return confirm('¿Eliminar usuario definitivamente? Todo su inventario caerá con él.');" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger font-monospace border-[#ff0055] text-[#ff0055] hover:bg-[#ff0055] hover:text-white rounded-0">ELIMINAR</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No hay perfiles disponibles en el sistema.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TAB: PUBLICACIONES -->
        <div id="tab-publicaciones" class="tab-content">
            <!-- TODAS -->
            <div class="section-title mt-5 mb-3 border-b border-[#333] pb-2">TODAS LAS PUBLICACIONES</div>
            <div class="bg-panel border border-[#333] p-0" style="background-color: var(--bg-panel);">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>EQUIPO</th>
                            <th>DUEÑO</th>
                            <th>FECHA</th>
                            <th>ESTADO VISUAL</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($todasCamisetas as $cam)
                        <tr>
                            <td>#{{ $cam->id }}</td>
                            <td class="fw-bold">{{ mb_strtoupper($cam->equipo) }} ({{ $cam->talla }})</td>
                            <td>{{ '@' . $cam->user->nombre_usuario }}</td>
                            <td>{{ $cam->created_at->format('d/m/Y') }}</td>
                            <td>
                                @if($cam->estado_aprobacion === 'aprobada')
                                    <span class="badge-status status-aprobada">APROBADA</span>
                                @else
                                    <span class="badge-status status-pendiente">PENDIENTE</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('camisetas.show', $cam) }}" target="_blank" title="Ver publicación" class="btn btn-sm text-primary font-monospace border border-primary hover:bg-primary hover:text-black rounded-0 px-2 d-flex align-items-center"><span class="material-symbols-outlined" style="font-size:18px;">visibility</span></a>
                                    <a href="{{ route('camisetas.edit', $cam) }}" target="_blank" title="Editar publicación" class="btn btn-sm text-warning font-monospace border border-warning hover:bg-warning hover:text-black rounded-0 px-2 d-flex align-items-center"><span class="material-symbols-outlined" style="font-size:18px;">edit</span></a>
                                    <form action="{{ route('camisetas.destroy', $cam) }}" method="POST" class="m-0 p-0" onsubmit="return confirm('¿Borrar esta publicación permamentemente?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Borrar publicación" class="btn btn-sm text-[#ff0055] font-monospace border border-[#ff0055] hover:bg-[#ff0055] hover:text-white rounded-0 px-2 d-flex align-items-center"><span class="material-symbols-outlined" style="font-size:18px;">delete</span></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TAB: INTERCAMBIOS -->
        <div id="tab-intercambios" class="tab-content">
            <div class="section-title">REGISTRO DE INTERCAMBIOS COMPLETADOS</div>
            <div class="bg-panel border border-[#333] p-0" style="background-color: var(--bg-panel);">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID TRUEQUE</th>
                            <th>FECHA ACUERDO</th>
                            <th>PARTICIPANTES</th>
                            <th>ESTADO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($intercambios as $tq)
                        <tr>
                            <td>#{{ $tq->id }}</td>
                            <td>{{ $tq->updated_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <span class="text-primary">{{ '@' . $tq->emisor->nombre_usuario }}</span> 
                                <span class="text-muted mx-2"><></span> 
                                <span class="text-primary">{{ '@' . $tq->receptor->nombre_usuario }}</span>
                            </td>
                            <td>
                                <span class="badge-status status-aprobada tracking-widest"><span class="material-symbols-outlined align-middle" style="font-size: 14px;">handshake</span> PACTADO</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No hay registros de intercambios finalizados aún.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script>
    function switchTab(tabId) {
        // Ocultar todos
        document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.nav-item-admin').forEach(el => el.classList.remove('active'));
        
        // Mostrar el seleccionado
        document.getElementById('tab-' + tabId).classList.add('active');
        document.getElementById('nav-' + tabId).classList.add('active');
    }

    function toggleSidebar() {
        const sidebar = document.getElementById('adminSidebar');
        sidebar.classList.toggle('open');
    }

    function closeSidebar() {
        if (window.innerWidth < 992) {
            document.getElementById('adminSidebar').classList.remove('open');
        }
    }

    // Cerrar sidebar al hacer clic fuera en móvil
    document.addEventListener('click', function(e) {
        const sidebar = document.getElementById('adminSidebar');
        const toggleBtn = document.getElementById('sidebarToggleBtn');
        if (window.innerWidth < 992 && sidebar && sidebar.classList.contains('open')) {
            if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        }
    });
</script>
@endsection
