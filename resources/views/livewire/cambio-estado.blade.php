<div class="flex items-center gap-2">
    @php $color = \App\Models\Contenido::$coloresEstado[$estadoActual] ?? '#6B7280'; @endphp
    <span class="w-2.5 h-2.5 rounded-full shrink-0" style="background-color: {{ $color }}"></span>
    <select wire:change="actualizarEstado($event.target.value)"
            class="bg-gray-800 border border-gray-700 rounded-lg px-3 py-1.5 text-sm text-gray-100 focus:outline-none focus:border-violet-500">
        @foreach ($estados as $valor => $etiqueta)
            <option value="{{ $valor }}" {{ $estadoActual === $valor ? 'selected' : '' }}>
                {{ $etiqueta }}
            </option>
        @endforeach
    </select>
    <span wire:loading class="text-xs text-gray-500">Guardando...</span>
</div>
