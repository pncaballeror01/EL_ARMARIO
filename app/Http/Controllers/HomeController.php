<?php

namespace App\Http\Controllers;

use App\Models\Camiseta;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $query = Camiseta::where('intercambiable', true)
            ->where('estado_aprobacion', 'aprobada');

        if (auth()->check()) {
            $query->where('user_id', '!=', auth()->id());
        }

        $camisetas = $query->with(['images', 'user'])->latest()->take(8)->get();

        // Todos los equipos con camisetas activas para la marquee
        $equipos = Camiseta::where('intercambiable', true)
            ->where('estado_aprobacion', 'aprobada')
            ->pluck('equipo')->unique()->values();

        return view('welcome', compact('camisetas', 'equipos'));
    }

    public function explorar(Request $request)
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $query = Camiseta::where('intercambiable', true)
            ->where('estado_aprobacion', 'aprobada');

        if (auth()->check()) {
            $query->where('user_id', '!=', auth()->id());
        }

        if ($request->filled('equipo')) {
            $query->where('equipo', 'like', '%' . $request->equipo . '%');
        }
        if ($request->filled('talla')) {
            $query->where('talla', $request->talla);
        }
        if ($request->filled('año')) {
            $query->where('año', $request->año);
        }

        $camisetas = $query->with(['images', 'user'])->latest()->paginate(3)->withQueryString();

        return view('explorar', compact('camisetas'));
    }
}
