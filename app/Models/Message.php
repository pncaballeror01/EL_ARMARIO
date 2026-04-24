<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_id',
        'user_id',
        'content',
        'trueque_id',
        'system_type',
    ];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_usuario');
    }

    public function trueque()
    {
        return $this->belongsTo(Trueque::class);
    }
}
