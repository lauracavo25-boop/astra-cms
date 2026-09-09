<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    public function index()
    {
        $marcas = Marca::withCount('contenidos')->orderBy('nombre')->get();
        return view('marcas.index', compact('marcas'));
    }

    public function create()
    {
        return view('marcas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'       => 'required|string|max:255',
            'descripcion'  => 'nullable|string',
            'tono'         => 'nullable|string|max:255',
            'objetivos'    => 'nullable|string',
            'pilares'      => 'nullable|string',
            'buyer_persona'=> 'nullable|string',
            'activa'       => 'boolean',
        ]);

        $validated['activa'] = $request->boolean('activa', true);
        Marca::create($validated);

        return redirect()->route('marcas.index')
            ->with('exito', 'Marca creada correctamente.');
    }

    public function show(Marca $marca)
    {
        $marca->load(['contenidos' => fn($q) => $q->orderBy('created_at', 'desc')]);
        return view('marcas.show', compact('marca'));
    }

    public function edit(Marca $marca)
    {
        return view('marcas.edit', compact('marca'));
    }

    public function update(Request $request, Marca $marca)
    {
        $validated = $request->validate([
            'nombre'       => 'required|string|max:255',
            'descripcion'  => 'nullable|string',
            'tono'         => 'nullable|string|max:255',
            'objetivos'    => 'nullable|string',
            'pilares'      => 'nullable|string',
            'buyer_persona'=> 'nullable|string',
            'activa'       => 'boolean',
        ]);

        $validated['activa'] = $request->boolean('activa');
        $marca->update($validated);

        return redirect()->route('marcas.index')
            ->with('exito', 'Marca actualizada correctamente.');
    }

    public function destroy(Marca $marca)
    {
        $marca->delete();
        return redirect()->route('marcas.index')
            ->with('exito', 'Marca eliminada correctamente.');
    }
}
