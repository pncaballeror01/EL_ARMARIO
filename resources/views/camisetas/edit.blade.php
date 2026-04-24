@extends('layouts.app')

@section('content')

<!-- NAVEGACIÓN SUPERIOR (VOLVER) -->
<nav class="bg-black py-3 border-bottom border-secondary sticky-top">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('dashboard') }}" class="text-decoration-none d-flex align-items-center text-white custom-hover">
            <span class="material-symbols-outlined text-primary me-2">arrow_back</span>
            <span class="font-monospace small fw-bold">VOLVER</span>
        </a>
        <a href="{{ route('dashboard') }}" class="text-decoration-none d-flex align-items-center text-white custom-hover">
            <span class="material-symbols-outlined text-primary me-2">checkroom</span>
            <span class="stencil-text h5 mb-0">EL ARMARIO</span>
        </a>
    </div>
</nav>

<style>
    :root {
        --primary: #E7FF00;
        --bg-asphalt: #121212;
        --bg-panel: #1A1A1A;
        --border-dark: #333333;
    }

    body {
        background-color: var(--bg-asphalt);
        color: white;
    }

    /* TÍTULO PÁGINA */
    .title-banner {
        background-color: #0a0a0a;
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" opacity="0.05"><rect width="100" height="100" fill="%23fff"/><path d="M0,0 L10,10 M20,0 L30,10" stroke="%23000" stroke-width="2"/></svg>'); /* Textura de asfalto simple */
        border-bottom: 2px solid var(--primary);
        position: relative;
        overflow: hidden;
    }
    .warning-tape-diagonal {
        position: absolute;
        top: 0; right: 0; bottom: 0; left: 0;
        background: repeating-linear-gradient(
            -45deg,
            transparent,
            transparent 48%,
            rgba(231, 255, 0, 0.05) 49%,
            rgba(231, 255, 0, 0.05) 51%,
            transparent 52%
        );
        background-size: 100px 100px;
        pointer-events: none;
    }

    h1.page-title {
        font-family: Impact, 'Space Grotesk', sans-serif;
        font-size: 2.5rem;
        font-weight: 900;
        text-transform: uppercase;
        color: white;
        letter-spacing: 2px;
        text-shadow: 2px 2px 0 #000;
        position: relative;
        z-index: 2;
        line-height: 1.1;
    }
    @media (min-width: 768px) {
        h1.page-title {
            font-size: 3.5rem;
        }
    }

    /* DEPÓSITO VISUAL */
    .deposito-container {
        background-color: var(--bg-panel);
        border: 2px solid var(--border-dark);
        border-radius: 0;
        box-shadow: 0 0 15px rgba(0,0,0,0.5);
    }
    
    .metal-grate {
        background-color: #0a0a0a;
        background-image: 
            linear-gradient(rgba(231, 255, 0, 0.03) 2px, transparent 2px),
            linear-gradient(90deg, rgba(231, 255, 0, 0.03) 2px, transparent 2px);
        background-size: 20px 20px;
        border: 2px solid var(--primary);
        box-shadow: inset 0 0 20px rgba(0,0,0,0.8), 0 0 10px rgba(231, 255, 0, 0.1);
        padding: 1.5rem;
        text-align: center;
    }

    .upload-zone {
        border: 2px dashed rgba(231, 255, 0, 0.5);
        background: rgba(0,0,0,0.6);
        padding: 3rem 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .upload-zone:hover, .upload-zone.dragover {
        border-color: var(--primary);
        background: rgba(231, 255, 0, 0.05);
    }

    .icon-camara {
        font-size: 5rem !important;
        color: var(--primary);
        filter: drop-shadow(0 0 10px rgba(231, 255, 0, 0.5));
        margin-bottom: 1rem;
    }

    .btn-select-photos {
        background-color: var(--bg-panel);
        border: 3px solid var(--primary);
        color: white;
        font-weight: 800;
        text-transform: uppercase;
        padding: 1rem;
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
        display: block;
        font-size: 1.2rem;
        transition: all 0.2s;
        border-radius: 0;
    }
    .btn-select-photos:hover {
        background-color: var(--primary);
        color: black;
        box-shadow: 0 0 15px rgba(231, 255, 0, 0.4);
    }

    /* PREVIEWS GRID */
    .preview-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
        margin-top: 1.5rem;
    }
    @media (max-width: 768px) {
        .preview-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    .preview-slot {
        aspect-ratio: 1;
        border: 1px solid var(--primary);
        background-color: #000;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        box-shadow: 0 0 5px rgba(231, 255, 0, 0.2);
    }
    .preview-slot img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .btn-remove {
        position: absolute;
        top: 5px; right: 5px;
        background: rgba(0,0,0,0.5);
        color: #ff0055;
        border: 1px solid #ff0055;
        width: 28px; height: 28px;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        font-weight: bold;
        transition: all 0.2s;
        z-index: 5;
    }
    .btn-remove:hover {
        background: #ff0055;
        color: white;
        box-shadow: 0 0 10px rgba(255, 0, 85, 0.6);
    }

    /* DATOS TÉCNICOS */
    .form-label-tactical {
        font-family: 'Space Grotesk', monospace;
        text-transform: uppercase;
        font-size: 0.9rem;
        color: #ccc;
        letter-spacing: 1px;
        font-weight: bold;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .input-tactical, .select-tactical {
        background-color: #000 !important;
        border: 2px solid var(--border-dark) !important;
        color: white !important;
        border-radius: 0 !important;
        padding: 1rem;
        font-family: monospace;
        font-size: 1rem;
        transition: all 0.2s;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.5);
    }
    
    .input-tactical:focus, .select-tactical:focus {
        background-color: #050505 !important;
        border-color: var(--primary) !important;
        box-shadow: 4px 4px 0px rgba(231, 255, 0, 0.3) !important;
        outline: none !important;
        color: white !important;
    }

    .input-tactical::placeholder {
        color: #666 !important;
    }

    /* INPUT GROUPS */
    .input-group-text-tactical {
        background-color: var(--bg-panel);
        border: 2px solid var(--border-dark);
        border-right: none;
        color: var(--primary);
        border-radius: 0;
    }
    
    .textarea-container {
        position: relative;
    }
    .terminal-cursor {
        position: absolute;
        top: 1.1rem;
        left: 1rem;
        color: var(--primary);
        font-family: monospace;
        font-weight: bold;
        pointer-events: none;
    }
    .textarea-tactical {
        padding-left: 2.5rem !important;
        min-height: 150px;
    }

    /* BOTÓN PRINCIPAL */
    .btn-launch {
        background-color: var(--primary);
        color: #000;
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 900;
        font-size: 1.8rem;
        text-transform: uppercase;
        border: none;
        border-radius: 0;
        padding: 1.5rem;
        width: 100%;
        position: relative;
        overflow: hidden;
        transition: all 0.3s;
        margin-top: 2rem;
        margin-bottom: 4rem;
        box-shadow: 0 4px 0 #99aa00, 0 10px 20px rgba(231, 255, 0, 0.2);
    }
    .btn-launch:hover {
        transform: translateY(2px);
        box-shadow: 0 2px 0 #99aa00, 0 15px 25px rgba(231, 255, 0, 0.4);
        background-color: #f0ff33;
    }
    .btn-launch:active {
        transform: translateY(4px);
        box-shadow: none;
    }
    
    .launch-icon {
        font-size: 2rem;
        vertical-align: middle;
        font-weight: bold;
    }
    
    .id-tag {
        position: absolute;
        bottom: -20px; right: 0;
        font-family: monospace;
        color: #555;
        font-size: 0.8rem;
    }

    /* SWITCH STYLES */
    .form-check-input:checked {
        background-color: var(--primary) !important;
        border-color: var(--primary) !important;
        box-shadow: 0 0 10px rgba(231,255,0,0.5);
    }
    .form-check-input:not(:checked) {
        background-color: #ff0055 !important;
        border-color: #ff0055 !important;
        box-shadow: inset 0 0 5px rgba(0,0,0,0.5);
    }
    .form-check-input {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="-4 -4 8 8"><circle r="3" fill="%23000"/></svg>') !important;
    }

    /* CUSTOM HOVER NAV */
    .custom-hover:hover .stencil-text, .custom-hover:hover span {
        color: var(--primary) !important;
    }
</style>

<!-- TÍTULO DE PÁGINA -->
<div class="title-banner py-5 px-3 px-md-5">
    <div class="warning-tape-diagonal"></div>
    <div class="container position-relative">
        <h1 class="page-title mb-0">
            EDITAR <span class="text-primary">JOYA DEL ARMARIO <span class="d-none d-md-inline" style="color: #444;">///</span></span>
        </h1>
    </div>
</div>

<section class="py-5 position-relative">
    <div class="container" style="max-width: 900px;">
        
        <!-- Formulario de Edición -->
        <form action="{{ route('camisetas.update', $camiseta->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Contenedor para IDs de imágenes eliminadas -->
            <div id="deletedImagesContainer"></div>
            
            <!-- 1. FORMULARIO INDUSTRIAL (DATOS TÉCNICOS) -->
            <div class="row g-4 mb-5">
                
                <!-- CLUB / EQUIPO -->
                <div class="col-md-4">
                    <label class="form-label-tactical">
                        CLUB / EQUIPO
                    </label>
                    <input type="text" name="equipo" class="form-control input-tactical w-100" placeholder="Ej: FC BARCELONA '96" value="{{ old('equipo', $camiseta->equipo) }}" required>
                </div>
                
                <!-- TALLA -->
                <div class="col-md-4">
                    <label class="form-label-tactical">
                        TALLA
                    </label>
                    <input type="text" name="talla" class="form-control input-tactical w-100" placeholder="Ej: XL / L" value="{{ old('talla', $camiseta->talla) }}" required>
                </div>
                
                <!-- FECHA / AÑO -->
                <div class="col-md-4">
                    <label class="form-label-tactical">
                        <span class="material-symbols-outlined text-primary fs-5" style="margin-left: -5px;">calendar_month</span> AÑO / TEMP.
                    </label>
                    <input type="text" name="año" class="form-control input-tactical w-100" placeholder="Ej: 1994 / 94-95" value="{{ old('año', $camiseta->año) }}" required>
                </div>
                
                <!-- ESTADO -->
                <div class="col-md-12">
                    <label class="form-label-tactical">
                        ESTADO (CALIDAD)
                    </label>
                    <select class="form-select select-tactical w-100" name="estado" required>
                        <option value="" disabled class="text-secondary">--- SELECCIONA ESTADO ---</option>
                        <option value="10/10 - NUEVA C/ ETIQUETAS" {{ old('estado', $camiseta->estado) == '10/10 - NUEVA C/ ETIQUETAS' ? 'selected' : '' }}>[ 10/10 ] NUEVA C/ ETIQUETAS</option>
                        <option value="9.5/10 - COMO NUEVA" {{ old('estado', $camiseta->estado) == '9.5/10 - COMO NUEVA' ? 'selected' : '' }}>[ 9.5/10 ] COMO NUEVA</option>
                        <option value="9/10 - USADA - EXCELENTE" {{ old('estado', $camiseta->estado) == '9/10 - USADA - EXCELENTE' ? 'selected' : '' }}>[ 9/10 ] USADA - EXCELENTE</option>
                        <option value="8/10 - USADA - MUY BUENA" {{ old('estado', $camiseta->estado) == '8/10 - USADA - MUY BUENA' ? 'selected' : '' }}>[ 8/10 ] USADA - MUY BUENA</option>
                        <option value="7/10 - USADA - BUENA" {{ old('estado', $camiseta->estado) == '7/10 - USADA - BUENA' ? 'selected' : '' }}>[ 7/10 ] USADA - BUENA (DEFECTOS MENORES)</option>
                        <option value="6/10 - USO INTENSO" {{ old('estado', $camiseta->estado) == '6/10 - USO INTENSO' ? 'selected' : '' }}>[ 6/10 ] USO INTENSO / VINTAGE GASTADA</option>
                    </select>
                </div>

                <!-- INTERCAMBIABLE -->
                <div class="col-md-12 mt-4">
                    <div class="form-check form-switch d-flex align-items-center gap-3" style="background-color: #000; border: 2px solid var(--border-dark); padding: 1rem; padding-left: 4rem;">
                        <input class="form-check-input" type="checkbox" role="switch" id="intercambiableSwitch" name="intercambiable" value="1" {{ old('intercambiable', $camiseta->intercambiable) ? 'checked' : '' }} style="width: 2.5rem; height: 1.25rem; transform: scale(1.5); margin-left: -3rem; cursor: pointer; border-color: var(--primary);">
                        <label class="form-check-label form-label-tactical mb-0" for="intercambiableSwitch" style="color: var(--primary); font-size: 1.1rem; cursor: pointer;" onclick="document.getElementById('intercambiableSwitch').click();">
                            JOYA DISPONIBLE PARA INTERCAMBIO TRATO
                        </label>
                    </div>
                </div>
                
                <!-- DESCRIPCIÓN -->
                <div class="col-12 mt-4">
                    <label class="form-label-tactical">
                        DESCRIPCIÓN
                    </label>
                    <div class="textarea-container">
                        <span class="terminal-cursor">></span>
                        <textarea name="descripcion" class="form-control input-tactical textarea-tactical w-100" placeholder="Usa CTRL + Intro para enviar. Cuenta la historia de esta pieza..." rows="5" required>{{ old('descripcion', $camiseta->descripcion) }}</textarea>
                    </div>
                </div>

            </div>

            <!-- 2. CARGADOR DE IMÁGENES -->
            <div class="deposito-container p-4 mb-5">
                <div class="metal-grate position-relative">
                    <div class="upload-zone" id="dropZone">
                        <span class="material-symbols-outlined icon-camara">switches</span>
                        <h3 class="stencil-text text-white mb-1" style="font-weight: 800;">DEPÓSITO DE FOTOS</h3>
                        <p class="font-monospace text-secondary small mb-4">(MÁXIMO 8 UNIDADES)</p>
                        
                        <input type="file" id="fileInput" name="images[]" multiple accept="image/*" class="d-none">
                        
                        <button type="button" class="btn btn-select-photos" onclick="document.getElementById('fileInput').click()">
                            SELECCIONAR FOTOS 
                        </button>
                        <div class="text-center mt-3">
                            <span class="font-monospace text-secondary" style="font-size: 0.8rem;">(Usa CTRL para selección múltiple o ARRASTRAR Y SOLTAR)</span>
                        </div>
                    </div>
                </div>
                
                <!-- PREVIEWS DINÁMICAS (Solo se muestran si hay imágenes) -->
                <div class="preview-grid" id="previewContainer">
                    <!-- Se rellenarán dinámicamente con JS, sin celdas vacías -->
                </div>
            </div>

            <!-- BOTÓN PRINCIPAL DE LANZAMIENTO -->
            <div class="position-relative mt-5">
                <button type="submit" class="btn btn-launch d-flex justify-content-center align-items-center gap-3">
                    <span class="material-symbols-outlined launch-icon text-black">published_with_changes</span>
                    GUARDAR CAMBIOS 
                    <span class="material-symbols-outlined launch-icon text-black">published_with_changes</span>
                </button>
                <div class="id-tag">SYS.ID: CRT.PUB.{{ rand(1000, 9999) }}-X</div>
            </div>

        </form>
    </div>
</section>

<!-- SCRIPTS PARA INTERACTIVIDAD UPLOAD -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const fileInput = document.getElementById('fileInput');
        const dropZone = document.getElementById('dropZone');
        const previewContainer = document.getElementById('previewContainer');
        const maxFiles = 8;
        
        let selectedFiles = [];
        
        // Imágenes que ya tiene la camiseta
        let existingImagesCount = {{ $camiseta->images->count() }};
        let deletedExistingImagesCount = 0;
        
        // Renderizar las imágenes iniciales desde PHP
        const initialImages = [
            @foreach($camiseta->images as $img)
            { id: {{ $img->id }}, url: '{{ Storage::url($img->image_path) }}' },
            @endforeach
        ];
        
        function renderExistingImages() {
            initialImages.forEach(imgData => {
                const slot = document.createElement('div');
                slot.className = 'preview-slot has-image';
                slot.id = 'existing-img-' + imgData.id;
                
                const img = document.createElement('img');
                img.src = imgData.url;
                
                const removeBtn = document.createElement('button');
                removeBtn.className = 'btn-remove';
                removeBtn.innerHTML = '<span class="material-symbols-outlined" style="font-size: 16px;">close</span>';
                removeBtn.type = 'button';
                removeBtn.onclick = function() { removeExistingImage(imgData.id); };
                
                slot.appendChild(img);
                slot.appendChild(removeBtn);
                
                previewContainer.appendChild(slot);
            });
        }
        
        function removeExistingImage(imageId) {
            // Ocultamos de la UI
            document.getElementById('existing-img-' + imageId).style.display = 'none';
            document.getElementById('existing-img-' + imageId).classList.remove('has-image');
            // Añadimos al contenedor de eliminadas
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'deleted_images[]';
            input.value = imageId;
            document.getElementById('deletedImagesContainer').appendChild(input);
            deletedExistingImagesCount++;
        }

        renderExistingImages();

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.classList.add('dragover'), false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.classList.remove('dragover'), false);
        });

        dropZone.addEventListener('drop', function(e) {
            let dt = e.dataTransfer;
            let files = dt.files;
            handleFiles(files);
        }, false);

        fileInput.addEventListener('change', function() {
            handleFiles(this.files);
        });

        function handleFiles(files) {
            const filesArray = Array.from(files);
            
            filesArray.forEach(file => {
                const currentTotal = (existingImagesCount - deletedExistingImagesCount) + selectedFiles.length;
                if (currentTotal < maxFiles && file.type.startsWith('image/')) {
                    selectedFiles.push(file);
                } else if(currentTotal >= maxFiles) {
                    alert('Has alcanzado el límite máximo de 8 fotos.');
                }
            });
            
            updatePreviews();
            updateFileInput();
        }

        function removeFile(index) {
            selectedFiles.splice(index, 1);
            updatePreviews();
            updateFileInput();
        }

        function updateFileInput() {
            const dt = new DataTransfer();
            selectedFiles.forEach(file => {
                dt.items.add(file);
            });
            fileInput.files = dt.files;
        }

        window.removeImageSlot = function(index) {
            removeFile(index);
        };

        function updatePreviews() {
            // Limpiamos los slots de JS pero mantenemos los originados por PHP que no se hayan borrado
            document.querySelectorAll('.preview-slot.new-image').forEach(el => el.remove());
            
            // Solo mostramos las imágenes que se han subido (sin slots vacíos)
            for (let i = 0; i < selectedFiles.length; i++) {
                const slot = document.createElement('div');
                slot.className = 'preview-slot has-image new-image';
                
                const file = selectedFiles[i];
                
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.onload = function() {
                    URL.revokeObjectURL(img.src); 
                }
                
                const removeBtn = document.createElement('button');
                removeBtn.className = 'btn-remove';
                removeBtn.innerHTML = '<span class="material-symbols-outlined" style="font-size: 16px;">close</span>';
                removeBtn.type = 'button';
                removeBtn.setAttribute('onclick', `removeImageSlot(${i})`);
                
                slot.appendChild(img);
                slot.appendChild(removeBtn);
                
                previewContainer.appendChild(slot);
            }
        }
        
        // Atajo teclado CTRL+Enter
        const textarea = document.querySelector('textarea[name="descripcion"]');
        textarea.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'Enter') {
                e.preventDefault();
                this.closest('form').submit();
            }
        });
    });
</script>

@endsection
