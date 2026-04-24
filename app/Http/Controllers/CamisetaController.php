<?php

namespace App\Http\Controllers;

use App\Models\Camiseta;
use Illuminate\Http\Request;

class CamisetaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('camisetas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'equipo' => 'required|string|max:255',
            'talla' => 'required|string|max:50',
            'año' => 'required|string|max:50',
            'estado' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'images' => 'required|array|min:1|max:8',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
            'intercambiable' => 'nullable|boolean'
        ]);

        $camiseta = Camiseta::create([
            'user_id' => auth()->id(),
            'equipo' => $validated['equipo'],
            'talla' => $validated['talla'],
            'año' => $validated['año'],
            'estado' => $validated['estado'],
            'descripcion' => $validated['descripcion'],
            'intercambiable' => $request->has('intercambiable')
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('camisetas', 'public');
                $camiseta->images()->create([
                    'image_path' => $path,
                    'order_index' => $index
                ]);
            }
        }

        return redirect()->route('armario')->with('success', '¡Joya subida al armario con éxito!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Camiseta $camiseta)
    {
        // Si está pendiente o rechazada, solo puede verla el dueño o un admin
        if ($camiseta->estado_aprobacion !== 'aprobada') {
            if (!auth()->check() || (auth()->id() !== $camiseta->user_id && !auth()->user()->isAdmin())) {
                abort(404, 'Publicación no encontrada o pendiente de validación por la administración.');
            }
        }

        $camiseta->load(['images', 'user']);
        return view('camisetas.show', compact('camiseta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Camiseta $camiseta)
    {
        if (auth()->id() !== $camiseta->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'No tienes permiso para editar esta joya.');
        }

        $camiseta->load('images');
        return view('camisetas.edit', compact('camiseta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Camiseta $camiseta)
    {
        if (auth()->id() !== $camiseta->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'No tienes permiso para editar esta joya.');
        }

        $validated = $request->validate([
            'equipo' => 'required|string|max:255',
            'talla' => 'required|string|max:50',
            'año' => 'required|string|max:50',
            'estado' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'images' => 'nullable|array|max:8',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'deleted_images' => 'nullable|array',
            'deleted_images.*' => 'exists:camiseta_images,id',
            'intercambiable' => 'nullable|boolean'
        ]);

        $currentImagesCount = $camiseta->images()->count();
        $deletedImagesCount = isset($validated['deleted_images']) ? count($validated['deleted_images']) : 0;
        $newImagesCount = $request->hasFile('images') ? count($request->file('images')) : 0;

        if (($currentImagesCount - $deletedImagesCount + $newImagesCount) > 8) {
            return back()->withErrors(['images' => 'El número total de imágenes no puede superar el límite de 8.'])->withInput();
        }

        if (($currentImagesCount - $deletedImagesCount + $newImagesCount) == 0) {
            return back()->withErrors(['images' => 'Debes incluir al menos una imagen en la publicación.'])->withInput();
        }

        $camiseta->update([
            'equipo' => $validated['equipo'],
            'talla' => $validated['talla'],
            'año' => $validated['año'],
            'estado' => $validated['estado'],
            'descripcion' => $validated['descripcion'],
            'intercambiable' => $request->has('intercambiable')
        ]);

        if (isset($validated['deleted_images'])) {
            foreach ($validated['deleted_images'] as $id) {
                $image = $camiseta->images()->find($id);
                if ($image) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }
        }

        if ($request->hasFile('images')) {
            $maxOrder = $camiseta->images()->max('order_index') ?? -1;
            foreach ($request->file('images') as $image) {
                $maxOrder++;
                $path = $image->store('camisetas', 'public');
                $camiseta->images()->create([
                    'image_path' => $path,
                    'order_index' => $maxOrder
                ]);
            }
        }

        return redirect()->route('camisetas.show', $camiseta)->with('success', '¡Joya actualizada en el armario con éxito!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Camiseta $camiseta)
    {
        if (auth()->id() !== $camiseta->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'No tienes permiso para eliminar esta joya.');
        }

        // Borrar imágenes físicas del storage
        foreach ($camiseta->images as $image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($image->image_path);
        }

        // Eloquent/BD se encargará de borrar los registros de camiseta_images por cascade si está configurado,
        // o las borramos manualmente por si acaso:
        $camiseta->images()->delete();
        $camiseta->delete();

        return redirect()->route('armario')->with('success', '¡Joya eliminada del armario con éxito!');
    }

    /**
     * Toggle the intercambiable status.
     */
    public function toggle(Request $request, Camiseta $camiseta)
    {
        if (auth()->id() !== $camiseta->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'No tienes permiso.');
        }

        $camiseta->intercambiable = $request->has('intercambiable');
        $camiseta->save();

        return back()->with('success', 'Visibilidad actualizada.');
    }
}
