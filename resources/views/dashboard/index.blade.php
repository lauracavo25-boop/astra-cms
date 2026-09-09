@extends('layouts.app')
@section('titulo', 'Dashboard')

@section('contenido')
<div class="space-y-6">

    {{-- Tarjetas de métricas --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $tarjetas = [
                ['label' => 'Contenidos totales', 'valor' => $totalContenidos,  'color' => 'violet'],
                ['label' => 'Marcas activas',     'valor' => $totalMarcas,       'color' => 'blue'],
                ['label' => 'Pendientes de grabar','valor' => $pendientesGrabar, 'color' => 'yellow'],
                ['label' => 'Publicados hoy',     'valor' => $publicadosHoy,     'color' => 'green'],
            ];
        @endphp

        @foreach ($tarjetas as $t)
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
                <p class="text-xs text-gray-500 uppercase tracking-wider">{{ $t['label'] }}</p>
                <p class="mt-2 text-3xl font-bold text-{{ $t['color'] }}-400">{{ $t['valor'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Próximos contenidos --}}
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
            <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Próximas publicaciones</h2>
            @forelse ($proximosContenidos as $contenido)
                <a href="{{ route('contenidos.show', $contenido) }}"
                   class="flex items-center justify-between py-3 border-b border-gray-800 last:border-0 hover:text-violet-300 transition-colors">
                    <div>
                        <span class="text-xs text-gray-500 font-mono">{{ $contenido->codigo }}</span>
                        <p class="text-sm font-medium">{{ $contenido->titulo }}</p>
                        <p class="text-xs text-gray-500">{{ $contenido->marca->nombre }}</p>
                    </div>
                    <span class="text-xs text-gray-500">{{ $contenido->fecha_publicacion_prevista->format('d/m') }}</span>
                </a>
            @empty
                <p class="text-sm text-gray-600">No hay contenidos próximos.</p>
            @endforelse
        </div>

        {{-- Contenidos por estado --}}
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
            <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Estado del pipeline</h2>
            @php
                $colores = \App\Models\Contenido::$coloresEstado;
                $etiquetas = [
                    'idea' => 'Idea', 'desarrollo' => 'Desarrollo', 'aprobado' => 'Aprobado',
                    'pendiente_grabar' => 'Pend. grabar', 'grabado' => 'Grabado',
                    'pendiente_edicion' => 'Pend. edición', 'editando' => 'Editando',
                    'revision' => 'Revisión', 'programado' => 'Programado',
                    'publicado' => 'Publicado', 'archivado' => 'Archivado',
                ];
            @endphp
            <div class="space-y-2">
                @foreach ($etiquetas as $key => $label)
                    @if (($contenidosPorEstado[$key] ?? 0) > 0)
                        <div class="flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full shrink-0" style="background-color: {{ $colores[$key] }}"></span>
                            <span class="text-sm text-gray-400 flex-1">{{ $label }}</span>
                            <span class="text-sm font-medium">{{ $contenidosPorEstado[$key] ?? 0 }}</span>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
