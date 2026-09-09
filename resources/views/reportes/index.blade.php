@extends('layouts.app')
@section('titulo', 'Reportes')

@section('contenido')
<div class="space-y-6">

    {{-- Métrica principal --}}
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
        <p class="text-xs text-gray-500 uppercase tracking-wider">Publicados este mes</p>
        <p class="text-4xl font-bold text-violet-400 mt-2">{{ $publicadosEsteMes }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Contenidos por marca --}}
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
            <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">
                Contenidos por marca
            </h2>
            <div class="space-y-3">
                @foreach ($contenidosPorMarca as $marca)
                    <div class="flex items-center gap-3">
                        <span class="text-sm flex-1">{{ $marca->nombre }}</span>
                        <div class="flex items-center gap-2">
                            <div class="h-1.5 bg-violet-600 rounded-full"
                                 style="width: {{ $marca->contenidos_count * 12 }}px; max-width: 120px;"></div>
                            <span class="text-sm font-medium w-6 text-right">{{ $marca->contenidos_count }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Contenidos por estado --}}
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
            <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">
                Pipeline por estado
            </h2>
            @php
                $colores = \App\Models\Contenido::$coloresEstado;
                $etiquetas = [
                    'idea' => 'Idea', 'desarrollo' => 'Desarrollo', 'aprobado' => 'Aprobado',
                    'pendiente_grabar' => 'Pend. grabar', 'grabado' => 'Grabado',
                    'pendiente_edicion' => 'Pend. edición', 'editando' => 'Editando',
                    'revision' => 'Revisión', 'programado' => 'Programado',
                    'publicado' => 'Publicado', 'archivado' => 'Archivado',
                ];
                $total = $contenidosPorEstado->sum();
            @endphp
            <div class="space-y-2">
                @foreach ($etiquetas as $key => $label)
                    @php $cant = $contenidosPorEstado[$key] ?? 0; @endphp
                    @if ($cant > 0)
                        <div class="flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full shrink-0" style="background-color: {{ $colores[$key] }}"></span>
                            <span class="text-sm text-gray-400 flex-1">{{ $label }}</span>
                            <span class="text-sm font-medium">{{ $cant }}</span>
                            <span class="text-xs text-gray-600 w-8 text-right">
                                {{ $total > 0 ? round($cant / $total * 100) : 0 }}%
                            </span>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
