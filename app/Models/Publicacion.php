<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Publicacion extends Model
{
    protected $table = 'publicaciones';
    protected $fillable = [
        'formato_id',
        'plataforma',
        'fecha_programada',
        'fecha_publicada',
        'url_publicada',
        'metricas',
    ];

    protected $casts = [
        'fecha_programada' => 'datetime',
        'fecha_publicada'  => 'datetime',
    ];

    public function formato(): BelongsTo
    {
        return $this->belongsTo(Formato::class);
    }
}
