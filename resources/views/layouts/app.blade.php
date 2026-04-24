<!DOCTYPE html>
<html lang="es" style="scroll-behavior: smooth;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EL ARMARIO - Vintage Jersey Swap</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700" rel="stylesheet">

    <style>
        :root {
            --primary-color: #E7FF00;
            --bg-dark: #000000;
        }

        body {
            background-color: var(--bg-dark);
            color: white;
            font-family: 'Space Grotesk', sans-serif;
            overflow-x: hidden;
        }

        /* --- SPINNER DE CARGA MEJORADO --- */
        #loader-wrapper {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: #000;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.8s ease, visibility 0.8s;
        }

        .loader-content {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .loader-ring {
            width: 80px;
            height: 80px;
            border: 4px solid #333;
            border-top-color: var(--primary-color);
            border-radius: 50%;
            animation: loader-spin 1s linear infinite;
        }

        .loader-icon-new {
            color: var(--primary-color);
            font-size: 30px !important;
            position: absolute;
            animation: app-pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        .loader-text {
            margin-top: 24px;
            color: white;
            font-weight: 900;
            font-size: 1.25rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            animation: app-pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes app-pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .5; }
        }
        @keyframes loader-spin {
            to { transform: rotate(360deg); }
        }

        .loader-hidden { opacity: 0; visibility: hidden; }
        /* ------------------------ */

        /* FONDO PRINCIPAL */
        .bg-main-image {
            background-image: url("{{ asset('img/fondo_Landing.png') }}");
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .bg-overlay {
            background-color: rgba(0, 0, 0, 0.7);
            position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1;
        }

        /* GALERÍA INTERACTIVA */
        .item-grial-interactive {
            background: #111;
            border: 1px solid #333;
            padding: 10px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .item-grial-interactive:hover {
            border-color: var(--primary-color);
            transform: scale(1.05);
            box-shadow: 0 0 25px rgba(231, 255, 0, 0.2);
        }

        .item-grial-interactive img {
            width: 100%;
            height: 280px;
            object-fit: cover;
            filter: none !important;
            transition: 0.3s;
        }

        .item-grial-interactive .label {
            padding: 15px 0 5px 0;
            font-weight: 800;
            color: var(--primary-color);
            text-align: center;
            font-size: 0.85rem;
            text-transform: uppercase;
        }

        /* VENTANAS MODALES */
        .modal-content {
            background-color: #000 !important;
            border: 2px solid var(--primary-color) !important;
            border-radius: 0;
        }

        .modal-header { border-bottom: 1px solid #333; }

        /* MARQUEE */
        .animate-marquee { display: flex; white-space: nowrap; animation: marquee 25s linear infinite; }
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        /* GENERALES */
        .bg-grid-metal {
            background-image: linear-gradient(rgba(231, 255, 0, 0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(231, 255, 0, 0.03) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .btn-primary-armario {
            background-color: var(--primary-color) !important;
            color: black !important; font-weight: 800; border-radius: 0; border: 2px solid var(--primary-color) !important;
        }
        .btn-primary-armario:hover { background-color: white !important; border-color: white !important; }

        .stencil-text { text-transform: uppercase; font-weight: 800; }
        .text-primary { color: var(--primary-color) !important; }
        .border-armario { border: 2px solid var(--primary-color) !important; }

        .form-control, .form-select { border-radius: 0; background: #111; color: white; border: 1px solid #333; }
        .form-control:focus { border-color: var(--primary-color); box-shadow: none; color: white; background: #111; }
    </style>
</head>
<body class="bg-grid-metal">

<div id="loader-wrapper">
    <div class="loader-content">
        <div class="loader-ring"></div>
        <span class="material-symbols-outlined loader-icon-new">checkroom</span>
    </div>
    <h2 class="loader-text stencil-text">EL ARMARIO</h2>
</div>

@yield('content')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    window.addEventListener("load", function() {
        const loader = document.getElementById("loader-wrapper");
        setTimeout(() => {
            loader.classList.add("loader-hidden");
        }, 1200); // Un pelín más de tiempo para que se vea la percha gigante
    });
</script>
</body>
</html>
