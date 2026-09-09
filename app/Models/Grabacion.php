<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grabacion extends Model
{
    protected $table = 'grabaciones';
    protected $fillable = [
        'contenido_id',
        'fecha',
        'lugar',
        'responsable_id',
        'checklist',
        'estado',
    ];

    protected $casts = [
        'fecha' => 'datetime',
    ];

    public function contenido(): BelongsTo
    {
        return $this->belongsTo(Contenido::class);
    }

    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }
}
