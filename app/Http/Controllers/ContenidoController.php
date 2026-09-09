<?php

namespace App\Http\Controllers;

use App\Models\Contenido;
use App\Models\Marca;
use App\Models\User;
use Illuminate\Http\Request;

class ContenidoController extends Controller
{
    private array $estados = [
        'idea', 'desarrollo', 'aprobado', 'pendiente_grabar',
        'grabado', 'pendiente_edicion', 'editando', 'revision',
        'programado', 'publicado', 'archivado',
    ];

    public function index(Request $request)
    {
        $query = Contenido::with('marca', 'responsable');

        if ($request->filled('marca_id')) {
            $query->where('marca_id', $request->marca_id);
        }
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $contenidos = $query->orderBy('created_at', 'desc')->paginate(15);
        $marcas     = Marca::where('activa', true)->orderBy('nombre')->get();

        return view('contenidos.index', compact('contenidos', 'marcas'));
    }

    public function create()
    {
        $marcas        = Marca::where('activa', true)->orderBy('nombre')->get();
        $responsables  = User::orderBy('name')->get();
        $estados       = $this->estados;
        return view('contenidos.create', compact('marcas', 'responsables', 'estados'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'marca_id'                   => 'required|exists:marcas,id',
            'codigo'                     => 'required|string|max:20|unique:contenidos,codigo',
            'titulo'                     => 'required|string|max:255',
            'objetivo'                   => 'nullable|string',
            'guion'                      => 'nullable|string',
            'estado'                     => 'required|in:' . implode(',', $this->estados),
            'responsable_id'             => 'nullable|exists:users,id',
            'fecha_publicacion_prevista' => 'nullable|date',
        ]);

        Contenido::create($validated);

        return redirect()->route('contenidos.index')
            ->with('exito', 'Contenido creado correctamente.');
    }

    public function show(Contenido $contenido)
    {
        $contenido->load('marca', 'responsable', 'formatos', 'recursos', 'comentarios.user', 'grabaciones');
        return view('contenidos.show', compact('contenido'));
    }

    public function edit(Contenido $contenido)
    {
        $marcas       = Marca::where('activa', true)->orderBy('nombre')->get();
        $responsables = User::orderBy('name')->get();
        $estados      = $this->estados;
        return view('contenidos.edit', compact('contenido', 'marcas', 'responsables', 'estados'));
    }

    public function update(Request $request, Contenido $contenido)
    {
        $validated = $request->validate([
            'marca_id'                   => 'required|exists:marcas,id',
            'codigo'                     => 'required|string|max:20|unique:contenidos,codigo,' . $contenido->id,
            'titulo'                     => 'required|string|max:255',
            'objetivo'                   => 'nullable|string',
            'guion'                      => 'nullable|string',
            'estado'                     => 'required|in:' . implode(',', $this->estados),
            'responsable_id'             => 'nullable|exists:users,id',
            'fecha_publicacion_prevista' => 'nullable|date',
        ]);

        $contenido->update($validated);

        return redirect()->route('contenidos.show', $contenido)
            ->with('exito', 'Contenido actualizado correctamente.');
    }

    public function destroy(Contenido $contenido)
    {
        $contenido->delete();
        return redirect()->route('contenidos.index')
            ->with('exito', 'Contenido eliminado correctamente.');
    }
}
