<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use App\Models\Contenido;

class PublicacionController extends Controller
{
    public function index()
    {
        $publicaciones = Publicacion::with('formato.contenido.marca')
            ->orderBy('fecha_programada')
            ->paginate(15);

        $programados = Contenido::with('marca')
            ->where('estado', 'programado')
            ->orderBy('fecha_publicacion_prevista')
            ->get();

        return view('publicacion.index', compact('publicaciones', 'programados'));
    }
}
