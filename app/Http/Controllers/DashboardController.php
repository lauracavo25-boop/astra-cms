<?php

namespace App\Http\Controllers;

use App\Models\Contenido;
use App\Models\Marca;

class DashboardController extends Controller
{
    public function index()
    {
        $totalContenidos   = Contenido::count();
        $totalMarcas       = Marca::where('activa', true)->count();
        $publicadosHoy     = Contenido::where('estado', 'publicado')
                                ->whereDate('updated_at', today())->count();
        $pendientesGrabar  = Contenido::where('estado', 'pendiente_grabar')->count();
        $proximosContenidos = Contenido::with('marca')
                                ->whereNotNull('fecha_publicacion_prevista')
                                ->where('fecha_publicacion_prevista', '>=', today())
                                ->orderBy('fecha_publicacion_prevista')
                                ->limit(5)
                                ->get();
        $contenidosPorEstado = Contenido::selectRaw('estado, count(*) as total')
                                ->groupBy('estado')
                                ->pluck('total', 'estado');

        return view('dashboard.index', compact(
            'totalContenidos',
            'totalMarcas',
            'publicadosHoy',
            'pendientesGrabar',
            'proximosContenidos',
            'contenidosPorEstado'
        ));
    }
}
