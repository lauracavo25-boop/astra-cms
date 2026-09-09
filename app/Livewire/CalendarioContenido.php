<?php

namespace App\Livewire;

use App\Models\Contenido;
use App\Models\Marca;
use Livewire\Component;

class CalendarioContenido extends Component
{
    public ?int $marcaSeleccionada = null;
    public array $eventos = [];

    public function mount(): void
    {
        $this->cargarEventos();
    }

    public function updatedMarcaSeleccionada(): void
    {
        $this->cargarEventos();
    }

    public function cargarEventos(): void
    {
        $query = Contenido::with('marca')
            ->whereNotNull('fecha_publicacion_prevista');

        if ($this->marcaSeleccionada) {
            $query->where('marca_id', $this->marcaSeleccionada);
        }

        $colores = Contenido::$coloresEstado;

        $this->eventos = $query->get()->map(function ($contenido) use ($colores) {
            return [
                'id'    => $contenido->id,
                'title' => "{$contenido->codigo} · {$contenido->titulo}",
                'start' => $contenido->fecha_publicacion_prevista->format('Y-m-d'),
                'color' => $colores[$contenido->estado] ?? '#6B7280',
                'extendedProps' => [
                    'contenido_id' => $contenido->id,
                    'estado'       => $contenido->estado,
                    'marca'        => $contenido->marca->nombre,
                ],
            ];
        })->toArray();

        // Notificar al JS de FullCalendar que los eventos cambiaron
        $this->dispatch('eventos-actualizados', eventos: $this->eventos);
    }

    public function render()
    {
        $marcas = Marca::where('activa', true)->orderBy('nombre')->get();
        return view('livewire.calendario-contenido', compact('marcas'));
    }
}
