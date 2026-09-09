@extends('layouts.app')
@section('titulo', 'Marcas')

@section('contenido')
<div class="space-y-4">
    <div class="flex justify-between items-center">
        <p class="text-sm text-gray-500">{{ $marcas->count() }} marcas registradas</p>
        <a href="{{ route('marcas.create') }}"
           class="px-4 py-2 bg-violet-600 hover:bg-violet-700 rounded-lg text-sm font-medium transition-colors">
            + Nueva marca
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        @forelse ($marcas as $marca)
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 flex flex-col gap-4">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="font-semibold text-gray-100">{{ $marca->nombre }}</h3>
                        <p class="text-xs text-gray-500 mt-1">{{ $marca->tono }}</p>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full {{ $marca->activa ? 'bg-green-900/50 text-green-400' : 'bg-gray-800 text-gray-500' }}">
                        {{ $marca->activa ? 'Activa' : 'Inactiva' }}
                    </span>
                </div>

                <p class="text-sm text-gray-400 line-clamp-2">{{ $marca->descripcion }}</p>

                <div class="flex items-center justify-between pt-2 border-t border-gray-800">
                    <span class="text-xs text-gray-500">{{ $marca->contenidos_count }} contenidos</span>
                    <div class="flex gap-2">
                        <a href="{{ route('marcas.show', $marca) }}"
                           class="text-xs text-violet-400 hover:text-violet-300 transition-colors">Ver</a>
                        <a href="{{ route('marcas.edit', $marca) }}"
                           class="text-xs text-gray-400 hover:text-gray-300 transition-colors">Editar</a>
                        <form method="POST" action="{{ route('marcas.destroy', $marca) }}"
                              onsubmit="return confirm('¿Eliminar esta marca?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-500 hover:text-red-400 transition-colors">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-16 text-gray-600">
                No hay marcas registradas. <a href="{{ route('marcas.create') }}" class="text-violet-400">Crear la primera</a>.
            </div>
        @endforelse
    </div>
</div>
@endsection
