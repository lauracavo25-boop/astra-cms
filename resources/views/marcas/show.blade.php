@extends('layouts.app')
@section('titulo', $marca->nombre)

@section('contenido')
<div class="space-y-6">
    <div class="flex gap-3">
        <a href="{{ route('marcas.edit', $marca) }}"
           class="px-4 py-2 bg-violet-600 hover:bg-violet-700 rounded-lg text-sm font-medium transition-colors">
            Editar
        </a>
        <a href="{{ route('marcas.index') }}"
           class="px-4 py-2 bg-gray-800 hover:bg-gray-700 rounded-lg text-sm font-medium transition-colors">
            ← Volver
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 space-y-4">
            @foreach ([
                ['Tono', $marca->tono],
                ['Objetivos', $marca->objetivos],
                ['Pilares', $marca->pilares],
                ['Buyer persona', $marca->buyer_persona],
                ['Descripción', $marca->descripcion],
            ] as [$label, $valor])
                @if ($valor)
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">{{ $label }}</p>
                        <p class="text-sm text-gray-300 mt-1">{{ $valor }}</p>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
            <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">
                Contenidos ({{ $marca->contenidos->count() }})
            </h3>
            <div class="space-y-2">
                @forelse ($marca->contenidos->take(10) as $contenido)
                    <a href="{{ route('contenidos.show', $contenido) }}"
                       class="flex items-center justify-between py-2 border-b border-gray-800 last:border-0 hover:text-violet-300 transition-colors">
                        <div>
                            <span class="text-xs font-mono text-gray-500">{{ $contenido->codigo }}</span>
                            <span class="text-sm ml-2">{{ $contenido->titulo }}</span>
                        </div>
                        <span class="text-xs text-gray-600">{{ $contenido->estado }}</span>
                    </a>
                @empty
                    <p class="text-sm text-gray-600">Sin contenidos aún.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
