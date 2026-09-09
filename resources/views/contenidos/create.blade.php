@extends('layouts.app')
@section('titulo', 'Nuevo contenido')

@section('contenido')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('contenidos.store') }}" class="space-y-5">
        @csrf

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-400 mb-1">Marca *</label>
                <select name="marca_id" required
                        class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-sm text-gray-100 focus:outline-none focus:border-violet-500">
                    <option value="">Seleccioná una marca</option>
                    @foreach ($marcas as $marca)
                        <option value="{{ $marca->id }}" {{ old('marca_id') == $marca->id ? 'selected' : '' }}>
                            {{ $marca->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('marca_id') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-1">Código *</label>
                <input type="text" name="codigo" value="{{ old('codigo') }}" placeholder="Ej: B-024" required
                       class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-sm text-gray-100 focus:outline-none focus:border-violet-500">
                @error('codigo') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Título *</label>
            <input type="text" name="titulo" value="{{ old('titulo') }}" required
                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-sm text-gray-100 focus:outline-none focus:border-violet-500">
            @error('titulo') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-400 mb-1">Estado *</label>
                <select name="estado" required
                        class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-sm text-gray-100 focus:outline-none focus:border-violet-500">
                    @foreach ($estados as $estado)
                        <option value="{{ $estado }}" {{ old('estado', 'idea') == $estado ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $estado)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-1">Fecha de publicación prevista</label>
                <input type="date" name="fecha_publicacion_prevista" value="{{ old('fecha_publicacion_prevista') }}"
                       class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-sm text-gray-100 focus:outline-none focus:border-violet-500">
            </div>
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Objetivo</label>
            <textarea name="objetivo" rows="2"
                      class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-sm text-gray-100 focus:outline-none focus:border-violet-500 resize-none">{{ old('objetivo') }}</textarea>
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Guion</label>
            <textarea name="guion" rows="5"
                      class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-sm text-gray-100 focus:outline-none focus:border-violet-500 resize-none">{{ old('guion') }}</textarea>
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Responsable</label>
            <select name="responsable_id"
                    class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-sm text-gray-100 focus:outline-none focus:border-violet-500">
                <option value="">Sin asignar</option>
                @foreach ($responsables as $user)
                    <option value="{{ $user->id }}" {{ old('responsable_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="px-6 py-2 bg-violet-600 hover:bg-violet-700 rounded-lg text-sm font-medium transition-colors">
                Guardar contenido
            </button>
            <a href="{{ route('contenidos.index') }}"
               class="px-6 py-2 bg-gray-800 hover:bg-gray-700 rounded-lg text-sm font-medium transition-colors">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
