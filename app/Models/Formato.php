<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Formato extends Model
{
    protected $fillable = [
        'contenido_id',
        'tipo',
        'estado',
        'notas',
    ];

    public function contenido(): BelongsTo
    {
        return $this->belongsTo(Contenido::class);
    }

    public function publicaciones(): HasMany
    {
        return $this->hasMany(Publicacion::class);
    }
}
