<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comentario extends Model
{
    protected $fillable = [
        'contenido_id',
        'user_id',
        'texto',
    ];

    public function contenido(): BelongsTo
    {
        return $this->belongsTo(Contenido::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
