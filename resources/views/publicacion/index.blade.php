@extends('layouts.app')
@section('titulo', 'Publicación')

@section('contenido')
<div class="space-y-6">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Programados para publicar --}}
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
            <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">
                Programados ({{ $programados->count() }})
            </h2>
            <div class="space-y-2">
                @forelse ($programados as $contenido)
                    <a href="{{ route('contenidos.show', $contenido) }}"
                       class="flex items-center justify-between py-2 border-b border-gray-800 last:border-0 hover:text-violet-300 transition-colors">
                        <div>
                            <span class="text-xs font-mono text-gray-500">{{ $contenido->codigo }}</span>
                            <p class="text-sm">{{ $contenido->titulo }}</p>
                            <p class="text-xs text-gray-500">{{ $contenido->marca->nombre }}</p>
                        </div>
                        <span class="text-xs text-green-400">{{ $contenido->fecha_publicacion_prevista?->format('d/m') ?? '—' }}</span>
                    </a>
                @empty
                    <p class="text-sm text-gray-600">No hay contenidos programados.</p>
                @endforelse
            </div>
        </div>

        {{-- Publicaciones recientes --}}
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
            <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">
                Publicaciones recientes
            </h2>
            <div class="space-y-2">
                @forelse ($publicaciones as $pub)
                    <div class="py-2 border-b border-gray-800 last:border-0">
                        <div class="flex items-center justify-between">
                            <p class="text-sm">{{ $pub->formato->contenido->titulo }}</p>
                            <span class="text-xs capitalize text-gray-500">{{ $pub->plataforma }}</span>
                        </div>
                        <p class="text-xs text-gray-500">
                            {{ $pub->fecha_publicada ? $pub->fecha_publicada->format('d/m/Y') : 'Programado: ' . $pub->fecha_programada?->format('d/m/Y') }}
                        </p>
                    </div>
                @empty
                    <p class="text-sm text-gray-600">No hay publicaciones registradas.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
