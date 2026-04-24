<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trueque extends Model
{
    use HasFactory;

    protected $fillable = [
        'emisor_id',
        'receptor_id',
        'camiseta_oferta_id',
        'camiseta_objetivo_id',
        'estado',
    ];

    public function emisor()
    {
        return $this->belongsTo(User::class, 'emisor_id', 'id_usuario');
    }

    public function receptor()
    {
        return $this->belongsTo(User::class, 'receptor_id', 'id_usuario');
    }

    public function oferta()
    {
        return $this->belongsTo(Camiseta::class, 'camiseta_oferta_id', 'id');
    }

    public function objetivo()
    {
        return $this->belongsTo(Camiseta::class, 'camiseta_objetivo_id', 'id');
    }
}
