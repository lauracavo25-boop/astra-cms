<?php

namespace App\Http\Controllers;

use App\Models\Contenido;
use App\Models\Marca;
use App\Models\Publicacion;

class ReporteController extends Controller
{
    public function index()
    {
        $contenidosPorMarca = Marca::withCount('contenidos')
            ->orderBy('contenidos_count', 'desc')
            ->get();

        $contenidosPorEstado = Contenido::selectRaw('estado, count(*) as total')
            ->groupBy('estado')
            ->pluck('total', 'estado');

        $publicadosEsteMes = Contenido::where('estado', 'publicado')
            ->whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', now()->year)
            ->count();

        return view('reportes.index', compact(
            'contenidosPorMarca',
            'contenidosPorEstado',
            'publicadosEsteMes'
        ));
    }
}
