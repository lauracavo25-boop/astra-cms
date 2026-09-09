<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Marca extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'tono',
        'objetivos',
        'pilares',
        'buyer_persona',
        'activa',
    ];

    protected $casts = [
        'activa' => 'boolean',
    ];

    public function contenidos(): HasMany
    {
        return $this->hasMany(Contenido::class);
    }
}
