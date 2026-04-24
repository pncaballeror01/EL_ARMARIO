<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Camiseta extends Model
{
    protected $fillable = [
        'user_id',
        'equipo',
        'talla',
        'año',
        'estado',
        'descripcion',
        'intercambiable',
        'estado_aprobacion'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_usuario');
    }

    public function images()
    {
        return $this->hasMany(CamisetaImage::class);
    }
}
