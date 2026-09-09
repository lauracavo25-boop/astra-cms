@extends('layouts.app')
@section('titulo', 'Edición')

@section('contenido')
<div class="space-y-4">
    @php
        $columnas = [
            'grabado'           => ['label' => 'Grabado',           'color' => 'orange'],
            'pendiente_edicion' => ['label' => 'Pend. edición',     'color' => 'yellow'],
            'editando'          => ['label' => 'Editando',          'color' => 'violet'],
            'revision'          => ['label' => 'En revisión',       'color' => 'pink'],
        ];
    @endphp

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ($columnas as $estado => $info)
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-4">
                <h3 class="text-xs font-semibold text-{{ $info['color'] }}-400 uppercase tracking-wider mb-3">
                    {{ $info['label'] }}
                    <span class="text-gray-600 ml-1">
                        ({{ $contenidos->where('estado', $estado)->count() }})
                    </span>
                </h3>
                <div class="space-y-2">
                    @forelse ($contenidos->where('estado', $estado) as $contenido)
                        <a href="{{ route('contenidos.show', $contenido) }}"
                           class="block bg-gray-800 rounded-lg p-3 hover:bg-gray-750 transition-colors">
                            <span class="text-xs font-mono text-gray-500">{{ $contenido->codigo }}</span>
                            <p class="text-sm font-medium mt-0.5">{{ $contenido->titulo }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $contenido->marca->nombre }}</p>
                        </a>
                    @empty
                        <p class="text-xs text-gray-600 text-center py-4">Sin contenidos</p>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
