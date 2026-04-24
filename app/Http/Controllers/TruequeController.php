<?php

namespace App\Http\Controllers;

use App\Models\Camiseta;
use Illuminate\Http\Request;

class TruequeController extends Controller
{
    public function create($id_camiseta)
    {
        $objetivo = Camiseta::findOrFail($id_camiseta);
        
        // Evitar que el usuario intente intercambiar consigo mismo
        if (auth()->check() && $objetivo->user_id === auth()->id()) {
            abort(403, 'No puedes intercambiar una camiseta contigo mismo.');
        }

        $misCamisetas = [];
        if (auth()->check()) {
            $misCamisetas = Camiseta::where('user_id', auth()->id())
                ->where('intercambiable', true)
                ->with('images')
                ->get();
        }

        return view('intercambio.create', compact('objetivo', 'misCamisetas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_objetivo' => 'required|exists:camisetas,id',
            'id_oferta' => 'required|exists:camisetas,id',
        ]);

        $objetivo = Camiseta::findOrFail($request->id_objetivo);
        $oferta = Camiseta::findOrFail($request->id_oferta);
        $emisorId = auth()->id();
        $receptorId = $objetivo->user_id;

        // Crear el trueque
        $trueque = \App\Models\Trueque::create([
            'emisor_id' => $emisorId,
            'receptor_id' => $receptorId,
            'camiseta_oferta_id' => $oferta->id,
            'camiseta_objetivo_id' => $objetivo->id,
            'estado' => 'pendiente',
        ]);

        // Buscar si ya existe un chat entre estos dos usuarios
        $chat = \App\Models\Chat::where(function ($q) use ($emisorId, $receptorId) {
            $q->where('user_one_id', $emisorId)->where('user_two_id', $receptorId);
        })->orWhere(function ($q) use ($emisorId, $receptorId) {
            $q->where('user_one_id', $receptorId)->where('user_two_id', $emisorId);
        })->first();

        // Si no existe, lo creamos
        if (!$chat) {
            $chat = \App\Models\Chat::create([
                'user_one_id' => $emisorId,
                'user_two_id' => $receptorId,
            ]);
        }

        // Crear el mensaje de propuesta
        \App\Models\Message::create([
            'chat_id' => $chat->id,
            'user_id' => $emisorId,
            'content' => 'Nueva propuesta de intercambio',
            'trueque_id' => $trueque->id,
            'system_type' => 'proposal',
        ]);

        // Retornar vista de espera/éxito
        return view('intercambio.success', compact('objetivo', 'oferta'));
    }
}
