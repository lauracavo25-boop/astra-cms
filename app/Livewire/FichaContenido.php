<?php

namespace App\Livewire;

use App\Models\Contenido;
use App\Models\Comentario;
use Livewire\Component;

class FichaContenido extends Component
{
    public ?Contenido $contenido = null;
    public bool $mostrarModal    = false;
    public string $nuevoComentario = '';

    protected $listeners = ['abrirFicha' => 'cargarContenido'];

    public function cargarContenido(int $contenidoId): void
    {
        $this->contenido = Contenido::with(
            'marca', 'responsable', 'formatos', 'recursos', 'comentarios.user'
        )->findOrFail($contenidoId);

        $this->mostrarModal = true;
    }

    public function cerrarModal(): void
    {
        $this->mostrarModal  = false;
        $this->contenido     = null;
        $this->nuevoComentario = '';
    }

    public function agregarComentario(): void
    {
        $this->validate([
            'nuevoComentario' => 'required|string|min:3',
        ]);

        Comentario::create([
            'contenido_id' => $this->contenido->id,
            'user_id'      => auth()->id(),
            'texto'        => $this->nuevoComentario,
        ]);

        $this->nuevoComentario = '';
        $this->contenido->load('comentarios.user');
    }

    public function render()
    {
        return view('livewire.ficha-contenido');
    }
}
