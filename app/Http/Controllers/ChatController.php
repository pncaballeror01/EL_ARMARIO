<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use App\Models\Trueque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $chats = Chat::where('user_one_id', $userId)
            ->orWhere('user_two_id', $userId)
            ->with(['messages' => function($q) {
                $q->latest();
            }])
            ->get()
            ->sortByDesc(function($chat) {
                return $chat->messages->first() ? $chat->messages->first()->created_at : $chat->created_at;
            });

        return view('chat.index', compact('chats'));
    }

    public function show($id)
    {
        $userId = auth()->id();
        $chat = Chat::where('id', $id)
            ->where(function($q) use ($userId) {
                $q->where('user_one_id', $userId)
                  ->orWhere('user_two_id', $userId);
            })
            ->with(['messages.trueque.oferta.images', 'messages.trueque.objetivo.images'])
            ->firstOrFail();

        // Marcar mensajes como leídos
        $chat->messages()->where(function ($query) use ($userId) {
            $query->where('user_id', '!=', $userId)->orWhereNull('user_id');
        })->where('is_read', false)->update(['is_read' => true]);

        $messages = $chat->messages()->oldest()->get();
        $otherUser = $chat->otherUser();

        return view('chat.show', compact('chat', 'messages', 'otherUser'));
    }

    public function sendMessage(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $userId = auth()->id();
        $chat = Chat::where('id', $id)
            ->where(function($q) use ($userId) {
                $q->where('user_one_id', $userId)
                  ->orWhere('user_two_id', $userId);
            })->firstOrFail();

        Message::create([
            'chat_id' => $chat->id,
            'user_id' => $userId,
            'content' => $request->content,
            'system_type' => 'normal',
        ]);

        return back();
    }

    public function acceptProposal(Request $request, $id)
    {
        $trueque = Trueque::findOrFail($id);
        
        if ($trueque->receptor_id !== auth()->id()) {
            abort(403);
        }

        // DB::transaction garantiza que TODAS las operaciones se aplican juntas
        // o, si algo falla a mitad, ninguna tiene efecto. Evita datos a medias.
        DB::transaction(function () use ($trueque) {
            $trueque->update(['estado' => 'aceptado']);

            // Incrementar contador de trueques exitosos de ambos usuarios
            $emisor = \App\Models\User::find($trueque->emisor_id);
            if ($emisor) {
                $emisor->increment('trueques_exitosos');
            }

            $receptor = \App\Models\User::find($trueque->receptor_id);
            if ($receptor) {
                $receptor->increment('trueques_exitosos');
            }

            // Cambiar de dueño las camisetas y quitarlas de "intercambiable"
            $camisetaOferta = \App\Models\Camiseta::find($trueque->camiseta_oferta_id);
            if ($camisetaOferta) {
                $camisetaOferta->update([
                    'user_id' => $trueque->receptor_id,
                    'intercambiable' => false
                ]);
            }

            $camisetaObjetivo = \App\Models\Camiseta::find($trueque->camiseta_objetivo_id);
            if ($camisetaObjetivo) {
                $camisetaObjetivo->update([
                    'user_id' => $trueque->emisor_id,
                    'intercambiable' => false
                ]);
            }

            // Publicar mensaje de sistema en el chat
            $emisorId = $trueque->emisor_id;
            $receptorId = $trueque->receptor_id;
            $chat = Chat::where(function ($q) use ($emisorId, $receptorId) {
                $q->where('user_one_id', $emisorId)->where('user_two_id', $receptorId);
            })->orWhere(function ($q) use ($emisorId, $receptorId) {
                $q->where('user_one_id', $receptorId)->where('user_two_id', $emisorId);
            })->first();

            if ($chat) {
                Message::create([
                    'chat_id' => $chat->id,
                    'user_id' => null,
                    'content' => auth()->user()->nombre_usuario . ' ha aceptado la propuesta.',
                    'system_type' => 'info',
                ]);
            }
        });

        return back()->with('success', 'Propuesta aceptada. Ahora podéis conversar para el intercambio.');
    }

    public function rejectProposal(Request $request, $id)
    {
        $trueque = Trueque::findOrFail($id);
        
        if ($trueque->receptor_id !== auth()->id()) {
            abort(403);
        }

        $trueque->update(['estado' => 'rechazado']);

        $emisorId = $trueque->emisor_id;
        $receptorId = $trueque->receptor_id;
        $chat = Chat::where(function ($q) use ($emisorId, $receptorId) {
            $q->where('user_one_id', $emisorId)->where('user_two_id', $receptorId);
        })->orWhere(function ($q) use ($emisorId, $receptorId) {
            $q->where('user_one_id', $receptorId)->where('user_two_id', $emisorId);
        })->first();

        if ($chat) {
            Message::create([
                'chat_id' => $chat->id,
                'user_id' => null,
                'content' => auth()->user()->nombre_usuario . ' ha rechazado tu propuesta.',
                'system_type' => 'info',
            ]);
        }

        return back()->with('success', 'Has rechazado la propuesta.');
    }

    public function destroy($id)
    {
        $userId = auth()->id();
        $chat = Chat::where('id', $id)
            ->where(function($q) use ($userId) {
                $q->where('user_one_id', $userId)
                  ->orWhere('user_two_id', $userId);
            })->firstOrFail();
            
        $chat->delete();
        
        return redirect()->route('buzon.index')->with('success', 'Chat eliminado correctamente.');
    }
}
