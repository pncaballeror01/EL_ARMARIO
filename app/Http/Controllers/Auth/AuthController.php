<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'nombre_usuario' => 'required|unique:usuarios',
            'ciudad' => 'required|string|max:100',
            'email' => 'required|email|unique:usuarios',
            'password' => 'required|min:6|confirmed',
        ], [
            'nombre_usuario.unique' => 'Ese nombre ya está en uso.',
            'ciudad.required' => 'Debes seleccionar una ciudad.',
            'email.unique' => 'El correo ya está registrado.',
            'password.min' => 'Mínimo 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.'
        ]);

        $user = User::create([
            'nombre_usuario' => $request->nombre_usuario,
            'ciudad' => $request->ciudad,
            'email' => $request->email,
            'password_hash' => Hash::make($request->password),
            'rol' => 'Usuario', // Perfil inicial por defecto [cite: 31]
            'estado_aprobacion' => 'pendiente', // Los nuevos usuarios deben ser aprobados
        ]);

        return redirect()->route('login')->with('success', 'Cuenta creada con éxito. Tu perfil está pendiente de validación por el administrador.');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $user = Auth::user();

            if ($user->estado_aprobacion === 'pendiente' && !$user->isAdmin()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors(['email' => 'Tu cuenta está siendo revisada por un administrador. No puedes iniciar sesión aún.']);
            }

            $request->session()->regenerate();
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->intended('/');
        }

        return back()->withErrors(['email' => 'Las credenciales no son correctas.']);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
