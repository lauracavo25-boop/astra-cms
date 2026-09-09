<?php

namespace App\Http\Controllers;

use App\Models\Grabacion;
use App\Models\Contenido;

class ProduccionController extends Controller
{
    public function index()
    {
        $grabaciones = Grabacion::with('contenido.marca', 'responsable')
            ->orderBy('fecha')
            ->paginate(15);

        $pendientesGrabar = Contenido::with('marca')
            ->whereIn('estado', ['pendiente_grabar', 'aprobado'])
            ->orderBy('fecha_publicacion_prevista')
            ->get();

        return view('produccion.index', compact('grabaciones', 'pendientesGrabar'));
    }

    public function show(Grabacion $grabacion)
    {
        $grabacion->load('contenido.marca', 'responsable');
        return view('produccion.show', compact('grabacion'));
    }
}
