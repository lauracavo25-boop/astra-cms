<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ContenidoController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\ProduccionController;
use App\Http\Controllers\EdicionController;
use App\Http\Controllers\PublicacionController;
use App\Http\Controllers\ReporteController;

// Redirigir la raíz al dashboard o login
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Marcas (ABM completo)
    Route::resource('/marcas', MarcaController::class);

    // Contenidos (ABM completo)
    Route::resource('/contenidos', ContenidoController::class);

    // Calendario
    Route::get('/calendario', [CalendarioController::class, 'index'])->name('calendario.index');

    // Producción
    Route::get('/produccion', [ProduccionController::class, 'index'])->name('produccion.index');
    Route::get('/produccion/{grabacion}', [ProduccionController::class, 'show'])->name('produccion.show');

    // Edición
    Route::get('/edicion', [EdicionController::class, 'index'])->name('edicion.index');

    // Publicación
    Route::get('/publicacion', [PublicacionController::class, 'index'])->name('publicacion.index');

    // Reportes
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
});

// Rutas de autenticación generadas por Laravel
require __DIR__.'/auth.php';
