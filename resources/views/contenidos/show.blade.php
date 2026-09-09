@extends('layouts.app')
@section('titulo', $contenido->codigo . ' · ' . $contenido->titulo)

@section('contenido')
<div class="space-y-6">
    <div class="flex gap-3 items-center flex-wrap">
        <a href="{{ route('contenidos.edit', $contenido) }}"
           class="px-4 py-2 bg-violet-600 hover:bg-violet-700 rounded-lg text-sm font-medium transition-colors">
            Editar
        </a>
        <a href="{{ route('contenidos.index') }}"
           class="px-4 py-2 bg-gray-800 hover:bg-gray-700 rounded-lg text-sm font-medium transition-colors">
            ← Volver
        </a>
        {{-- Cambio de estado en tiempo real --}}
        @livewire('cambio-estado', ['contenido' => $contenido])
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Info principal --}}
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 space-y-4">
                <div class="flex items-center gap-3">
                    <span class="font-mono text-sm text-violet-400">{{ $contenido->codigo }}</span>
                    <span class="text-xs text-gray-500">{{ $contenido->marca->nombre }}</span>
                </div>
                <h2 class="text-xl font-semibold">{{ $contenido->titulo }}</h2>
                @if ($contenido->objetivo)
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Objetivo</p>
                        <p class="text-sm text-gray-300">{{ $contenido->objetivo }}</p>
                    </div>
                @endif
                @if ($contenido->guion)
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Guion</p>
                        <p class="text-sm text-gray-300 whitespace-pre-line">{{ $contenido->guion }}</p>
                    </div>
                @endif
            </div>

            {{-- Formatos --}}
            @if ($contenido->formatos->count())
                <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-3">Formatos</h3>
                    <div class="space-y-2">
                        @foreach ($contenido->formatos as $formato)
                            <div class="flex items-center justify-between py-2 border-b border-gray-800 last:border-0">
                                <span class="text-sm capitalize">{{ $formato->tipo }}</span>
                                <span class="text-xs text-gray-500">{{ $formato->estado }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Comentarios --}}
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
                <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-3">
                    Comentarios ({{ $contenido->comentarios->count() }})
                </h3>
                <div class="space-y-3 mb-4">
                    @forelse ($contenido->comentarios as $comentario)
                        <div class="flex gap-3">
                            <div class="w-7 h-7 rounded-full bg-violet-900 flex items-center justify-center text-xs shrink-0">
                                {{ strtoupper(substr($comentario->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">{{ $comentario->user->name }} · {{ $comentario->created_at->diffForHumans() }}</p>
                                <p class="text-sm text-gray-300 mt-0.5">{{ $comentario->texto }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-600">Sin comentarios aún.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Sidebar derecho --}}
        <div class="space-y-4">
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 space-y-3">
                <div>
                    <p class="text-xs text-gray-500">Responsable</p>
                    <p class="text-sm">{{ $contenido->responsable?->name ?? 'Sin asignar' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Publicación prevista</p>
                    <p class="text-sm">{{ $contenido->fecha_publicacion_prevista?->format('d/m/Y') ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Creado</p>
                    <p class="text-sm">{{ $contenido->created_at->format('d/m/Y') }}</p>
                </div>
            </div>

            {{-- Recursos --}}
            @if ($contenido->recursos->count())
                <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Recursos</h3>
                    @foreach ($contenido->recursos as $recurso)
                        <div class="py-2 border-b border-gray-800 last:border-0">
                            <p class="text-xs text-gray-500 capitalize">{{ $recurso->tipo }}</p>
                            <a href="{{ $recurso->url }}" target="_blank"
                               class="text-xs text-violet-400 hover:text-violet-300 break-all">
                                {{ $recurso->descripcion ?? $recurso->url }}
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
