<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'nombre_usuario',
        'nombre_completo',
        'ciudad',
        'email',
        'password_hash',
        'rol',
        'rol_id',
        'trueques_exitosos',
        'estado_aprobacion',
    ];

    public function isAdmin()
    {
        return $this->rol_id === 2;
    }

    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    public function getAuthPassword() {
        return $this->password_hash;
    }

    public function camisetas()
    {
        return $this->hasMany(\App\Models\Camiseta::class, 'user_id', 'id_usuario');
    }

    public function unreadMessagesCount()
    {
        return \App\Models\Message::whereHas('chat', function ($q) {
            $q->where('user_one_id', $this->id_usuario)
              ->orWhere('user_two_id', $this->id_usuario);
        })
        ->where('user_id', '!=', $this->id_usuario)
        ->where('is_read', false)
        ->count();
    }
}
