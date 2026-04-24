<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CamisetaImage extends Model
{
    protected $fillable = [
        'camiseta_id',
        'image_path',
        'order_index'
    ];

    public function camiseta()
    {
        return $this->belongsTo(Camiseta::class);
    }
}
