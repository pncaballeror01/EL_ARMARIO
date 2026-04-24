<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Muestra el perfil público de un usuario.
     * Carga todas sus camisetas (disponibles y no disponibles) para que
     * el visitante pueda ver el inventario completo del vendedor/coleccionista.
     */
    public function show($id)
    {
        $perfil = User::where('id_usuario', $id)
            ->firstOrFail();

        $camisetas = $perfil->camisetas()
            ->with('images')
            ->latest()
            ->get();

        return view('perfil.show', compact('perfil', 'camisetas'));
    }
}
