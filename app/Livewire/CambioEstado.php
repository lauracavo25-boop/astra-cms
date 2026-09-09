<?php

namespace App\Livewire;

use App\Models\Contenido;
use Livewire\Component;

class CambioEstado extends Component
{
    public Contenido $contenido;
    public string $estadoActual;

    public array $estados = [
        'idea'              => 'Idea',
        'desarrollo'        => 'Desarrollo',
        'aprobado'          => 'Aprobado',
        'pendiente_grabar'  => 'Pendiente de grabar',
        'grabado'           => 'Grabado',
        'pendiente_edicion' => 'Pendiente de edición',
        'editando'          => 'Editando',
        'revision'          => 'Revisión',
        'programado'        => 'Programado',
        'publicado'         => 'Publicado',
        'archivado'         => 'Archivado',
    ];

    public function mount(Contenido $contenido): void
    {
        $this->contenido    = $contenido;
        $this->estadoActual = $contenido->estado;
    }

    public function actualizarEstado(string $nuevoEstado): void
    {
        if (!array_key_exists($nuevoEstado, $this->estados)) {
            return;
        }

        $this->contenido->update(['estado' => $nuevoEstado]);
        $this->estadoActual = $nuevoEstado;

        $this->dispatch('estado-actualizado', estado: $nuevoEstado);
    }

    public function render()
    {
        return view('livewire.cambio-estado');
    }
}
