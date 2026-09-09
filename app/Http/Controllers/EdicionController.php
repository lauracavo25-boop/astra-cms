<?php

namespace App\Http\Controllers;

use App\Models\Contenido;

class EdicionController extends Controller
{
    public function index()
    {
        $contenidos = Contenido::with('marca', 'responsable')
            ->whereIn('estado', ['grabado', 'pendiente_edicion', 'editando', 'revision'])
            ->orderBy('fecha_publicacion_prevista')
            ->get();

        return view('edicion.index', compact('contenidos'));
    }
}
