<div>
    @if ($mostrarModal && $contenido)
        {{-- Overlay --}}
        <div class="fixed inset-0 bg-black/70 z-40" wire:click="cerrarModal"></div>

        {{-- Modal --}}
        <div class="fixed inset-y-0 right-0 w-full max-w-2xl bg-gray-900 border-l border-gray-800 z-50 overflow-y-auto shadow-2xl">
            <div class="p-6 space-y-6">

                {{-- Header --}}
                <div class="flex items-start justify-between">
                    <div>
                        <span class="font-mono text-sm text-violet-400">{{ $contenido->codigo }}</span>
                        <h2 class="text-lg font-semibold mt-1">{{ $contenido->titulo }}</h2>
                        <p class="text-sm text-gray-500">{{ $contenido->marca->nombre }}</p>
                    </div>
                    <button wire:click="cerrarModal"
                            class="text-gray-500 hover:text-gray-300 text-xl leading-none transition-colors">
                        ✕
                    </button>
                </div>

                {{-- Estado --}}
                <div>
                    @livewire('cambio-estado', ['contenido' => $contenido], key('ficha-' . $contenido->id))
                </div>

                {{-- Datos principales --}}
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-xs text-gray-500">Responsable</p>
                        <p>{{ $contenido->responsable?->name ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Publicación prevista</p>
                        <p>{{ $contenido->fecha_publicacion_prevista?->format('d/m/Y') ?? '—' }}</p>
                    </div>
                </div>

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

                {{-- Formatos --}}
                @if ($contenido->formatos->count())
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-2">Formatos</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($contenido->formatos as $formato)
                                <span class="px-2 py-1 bg-gray-800 rounded text-xs capitalize">
                                    {{ $formato->tipo }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Recursos --}}
                @if ($contenido->recursos->count())
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-2">Recursos</p>
                        @foreach ($contenido->recursos as $recurso)
                            <a href="{{ $recurso->url }}" target="_blank"
                               class="block text-xs text-violet-400 hover:text-violet-300 py-1">
                                {{ $recurso->descripcion ?? $recurso->url }}
                            </a>
                        @endforeach
                    </div>
                @endif

                {{-- Comentarios --}}
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-3">
                        Comentarios ({{ $contenido->comentarios->count() }})
                    </p>
                    <div class="space-y-3 mb-4">
                        @forelse ($contenido->comentarios as $comentario)
                            <div class="flex gap-3">
                                <div class="w-7 h-7 rounded-full bg-violet-900 flex items-center justify-center text-xs shrink-0">
                                    {{ strtoupper(substr($comentario->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">
                                        {{ $comentario->user->name }} · {{ $comentario->created_at->diffForHumans() }}
                                    </p>
                                    <p class="text-sm text-gray-300 mt-0.5">{{ $comentario->texto }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-600">Sin comentarios.</p>
                        @endforelse
                    </div>

                    {{-- Agregar comentario --}}
                    <div class="flex gap-2">
                        <input type="text" wire:model="nuevoComentario" placeholder="Escribir comentario..."
                               wire:keydown.enter="agregarComentario"
                               class="flex-1 bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-gray-100 focus:outline-none focus:border-violet-500">
                        <button wire:click="agregarComentario"
                                class="px-4 py-2 bg-violet-600 hover:bg-violet-700 rounded-lg text-sm transition-colors">
                            Enviar
                        </button>
                    </div>
                    @error('nuevoComentario')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Acciones --}}
                <div class="flex gap-3 pt-4 border-t border-gray-800">
                    <a href="{{ route('contenidos.show', $contenido) }}"
                       class="px-4 py-2 bg-gray-800 hover:bg-gray-700 rounded-lg text-sm transition-colors">
                        Ver ficha completa
                    </a>
                    <a href="{{ route('contenidos.edit', $contenido) }}"
                       class="px-4 py-2 bg-violet-600 hover:bg-violet-700 rounded-lg text-sm transition-colors">
                        Editar
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
