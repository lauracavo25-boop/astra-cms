@extends('layouts.app')
@section('titulo', 'Producción')

@section('contenido')
<div class="space-y-6">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Pendientes de grabar --}}
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
            <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">
                Pendientes de grabar ({{ $pendientesGrabar->count() }})
            </h2>
            <div class="space-y-2">
                @forelse ($pendientesGrabar as $contenido)
                    <a href="{{ route('contenidos.show', $contenido) }}"
                       class="flex items-center justify-between py-2 border-b border-gray-800 last:border-0 hover:text-violet-300 transition-colors">
                        <div>
                            <span class="text-xs font-mono text-gray-500">{{ $contenido->codigo }}</span>
                            <p class="text-sm">{{ $contenido->titulo }}</p>
                            <p class="text-xs text-gray-500">{{ $contenido->marca->nombre }}</p>
                        </div>
                        <span class="text-xs text-yellow-400">{{ $contenido->fecha_publicacion_prevista?->format('d/m') ?? '—' }}</span>
                    </a>
                @empty
                    <p class="text-sm text-gray-600">No hay contenidos pendientes de grabar.</p>
                @endforelse
            </div>
        </div>

        {{-- Grabaciones programadas --}}
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
            <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">
                Grabaciones ({{ $grabaciones->total() }})
            </h2>
            <div class="space-y-2">
                @forelse ($grabaciones as $grabacion)
                    <div class="py-2 border-b border-gray-800 last:border-0">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium">{{ $grabacion->contenido->titulo }}</p>
                            <span class="text-xs text-gray-500">{{ $grabacion->fecha->format('d/m H:i') }}</span>
                        </div>
                        <p class="text-xs text-gray-500">{{ $grabacion->lugar }}</p>
                    </div>
                @empty
                    <p class="text-sm text-gray-600">No hay grabaciones registradas.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
