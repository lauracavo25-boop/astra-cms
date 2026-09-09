@extends('layouts.app')
@section('titulo', 'Editar marca · ' . $marca->nombre)

@section('contenido')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('marcas.update', $marca) }}" class="space-y-5">
        @csrf @method('PUT')

        @foreach ([
            ['nombre', 'Nombre', true],
            ['tono', 'Tono de comunicación', false],
        ] as [$campo, $label, $requerido])
            <div>
                <label class="block text-sm text-gray-400 mb-1">{{ $label }}{{ $requerido ? ' *' : '' }}</label>
                <input type="text" name="{{ $campo }}" value="{{ old($campo, $marca->$campo) }}"
                       class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-sm text-gray-100 focus:outline-none focus:border-violet-500"
                       {{ $requerido ? 'required' : '' }}>
                @error($campo) <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
            </div>
        @endforeach

        @foreach ([
            ['descripcion', 'Descripción'],
            ['objetivos', 'Objetivos'],
            ['pilares', 'Pilares de contenido'],
            ['buyer_persona', 'Buyer persona'],
        ] as [$campo, $label])
            <div>
                <label class="block text-sm text-gray-400 mb-1">{{ $label }}</label>
                <textarea name="{{ $campo }}" rows="3"
                          class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-sm text-gray-100 focus:outline-none focus:border-violet-500 resize-none">{{ old($campo, $marca->$campo) }}</textarea>
            </div>
        @endforeach

        <div class="flex items-center gap-2">
            <input type="checkbox" name="activa" id="activa" value="1" {{ $marca->activa ? 'checked' : '' }}
                   class="rounded border-gray-600 bg-gray-800 text-violet-500">
            <label for="activa" class="text-sm text-gray-400">Marca activa</label>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="px-6 py-2 bg-violet-600 hover:bg-violet-700 rounded-lg text-sm font-medium transition-colors">
                Guardar cambios
            </button>
            <a href="{{ route('marcas.show', $marca) }}"
               class="px-6 py-2 bg-gray-800 hover:bg-gray-700 rounded-lg text-sm font-medium transition-colors">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
