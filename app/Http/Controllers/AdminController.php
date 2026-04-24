<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Camiseta;
use App\Models\User;
use App\Models\Trueque;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsuarios = User::count();
        $totalPublicaciones = Camiseta::count(); // Todas las creadas
        $totalIntercambios = Trueque::count();

        $pendientes = Camiseta::where('estado_aprobacion', 'pendiente')->with(['user', 'images'])->latest()->get();
        $todasCamisetas = Camiseta::with(['user', 'images'])->latest()->get();
        $usuarios = User::where('rol', '!=', 'Superadministrador')->latest()->get();
        $intercambios = Trueque::with(['emisor', 'receptor'])->latest()->get();

        return view('admin.dashboard', compact('totalUsuarios', 'totalPublicaciones', 'totalIntercambios', 'pendientes', 'todasCamisetas', 'usuarios', 'intercambios'));
    }

    public function aprobarCamiseta($id)
    {
        $camiseta = Camiseta::findOrFail($id);
        $camiseta->update(['estado_aprobacion' => 'aprobada']);
        return back()->with('success', 'Publicación APROBADA y visible para todos.');
    }

    public function rechazarCamiseta($id)
    {
        $camiseta = Camiseta::findOrFail($id);
        
        // Requisito 2 (Pregunta Confirmada): Exterminación
        foreach($camiseta->images as $img) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($img->image_path);
            $img->delete();
        }
        $camiseta->delete();

        return back()->with('success', 'Publicación RECHAZADA y eliminada del sistema.');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit_user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'nombre_usuario' => 'required|string|max:50|unique:usuarios,nombre_usuario,' . $id . ',id_usuario',
            'nombre_completo' => 'nullable|string|max:100',
            'email' => 'required|string|email|max:100|unique:usuarios,email,' . $id . ',id_usuario',
            'ciudad' => 'nullable|string|max:100'
        ]);

        $user->update([
            'nombre_usuario' => $request->nombre_usuario,
            'nombre_completo' => $request->nombre_completo,
            'email' => $request->email,
            'ciudad' => $request->ciudad,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Información personal del usuario actualizada correctamente.');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        if($user->rol_id === 2) {
            return back()->with('error', 'No puedes eliminar a otro administrador.');
        }
        $user->delete();
        return back()->with('success', 'Usuario purgado del sistema.');
    }
}
