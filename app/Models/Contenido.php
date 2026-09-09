<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contenido extends Model
{
    protected $fillable = [
        'marca_id',
        'codigo',
        'titulo',
        'objetivo',
        'guion',
        'estado',
        'responsable_id',
        'fecha_publicacion_prevista',
    ];

    protected $casts = [
        'fecha_publicacion_prevista' => 'date',
    ];

    // Colores por estado para el calendario
    public static array $coloresEstado = [
        'idea'               => '#6B7280',
        'desarrollo'         => '#3B82F6',
        'aprobado'           => '#86EFAC',
        'pendiente_grabar'   => '#FDE68A',
        'grabado'            => '#F97316',
        'pendiente_edicion'  => '#A78BFA',
        'editando'           => '#C084FC',
        'revision'           => '#F472B6',
        'programado'         => '#16A34A',
        'publicado'          => '#22C55E',
        'archivado'          => '#EF4444',
    ];

    public function marca(): BelongsTo
    {
        return $this->belongsTo(Marca::class);
    }

    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function formatos(): HasMany
    {
        return $this->hasMany(Formato::class);
    }

    public function recursos(): HasMany
    {
        return $this->hasMany(Recurso::class);
    }

    public function comentarios(): HasMany
    {
        return $this->hasMany(Comentario::class);
    }

    public function grabaciones(): HasMany
    {
        return $this->hasMany(Grabacion::class);
    }
}
