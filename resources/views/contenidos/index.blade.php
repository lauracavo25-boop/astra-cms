@extends('layouts.app')
@section('titulo', 'Biblioteca de Contenidos')

@section('contenido')
<div class="space-y-4">
    {{-- Filtros --}}
    <form method="GET" class="flex gap-3 items-end flex-wrap">
        <div>
            <label class="block text-xs text-gray-500 mb-1">Marca</label>
            <select name="marca_id"
                    class="bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-gray-100 focus:outline-none focus:border-violet-500">
                <option value="">Todas las marcas</option>
                @foreach ($marcas as $marca)
                    <option value="{{ $marca->id }}" {{ request('marca_id') == $marca->id ? 'selected' : '' }}>
                        {{ $marca->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Estado</label>
            <select name="estado"
                    class="bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-gray-100 focus:outline-none focus:border-violet-500">
                <option value="">Todos los estados</option>
                @foreach (['idea','desarrollo','aprobado','pendiente_grabar','grabado','pendiente_edicion','editando','revision','programado','publicado','archivado'] as $estado)
                    <option value="{{ $estado }}" {{ request('estado') == $estado ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $estado)) }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit"
                class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-sm transition-colors">
            Filtrar
        </button>
        <a href="{{ route('contenidos.create') }}"
           class="ml-auto px-4 py-2 bg-violet-600 hover:bg-violet-700 rounded-lg text-sm font-medium transition-colors">
            + Nuevo contenido
        </a>
    </form>

    {{-- Tabla --}}
    <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-800 text-xs text-gray-500 uppercase tracking-wider">
                    <th class="text-left px-4 py-3">Código</th>
                    <th class="text-left px-4 py-3">Título</th>
                    <th class="text-left px-4 py-3">Marca</th>
                    <th class="text-left px-4 py-3">Estado</th>
                    <th class="text-left px-4 py-3">Publicación</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @forelse ($contenidos as $contenido)
                    @php $color = \App\Models\Contenido::$coloresEstado[$contenido->estado] ?? '#6B7280'; @endphp
                    <tr class="hover:bg-gray-800/50 transition-colors">
                        <td class="px-4 py-3 font-mono text-xs text-gray-400">{{ $contenido->codigo }}</td>
                        <td class="px-4 py-3 font-medium">{{ $contenido->titulo }}</td>
                        <td class="px-4 py-3 text-gray-400">{{ $contenido->marca->nombre }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-1.5 text-xs">
                                <span class="w-2 h-2 rounded-full" style="background-color: {{ $color }}"></span>
                                {{ ucfirst(str_replace('_', ' ', $contenido->estado)) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-500 text-xs">
                            {{ $contenido->fecha_publicacion_prevista?->format('d/m/Y') ?? '—' }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('contenidos.show', $contenido) }}"
                               class="text-xs text-violet-400 hover:text-violet-300 transition-colors">Ver</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-gray-600">
                            No hay contenidos. <a href="{{ route('contenidos.create') }}" class="text-violet-400">Crear el primero</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $contenidos->links() }}
</div>
@endsection
