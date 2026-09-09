<div>
    {{-- Selector de marca --}}
    <div class="flex items-center gap-4 mb-6">
        <div>
            <label class="block text-xs text-gray-500 mb-1">Filtrar por marca</label>
            <select wire:model.live="marcaSeleccionada"
                    class="bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-gray-100 focus:outline-none focus:border-violet-500">
                <option value="">Todas las marcas</option>
                @foreach ($marcas as $marca)
                    <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                @endforeach
            </select>
        </div>

        {{-- Leyenda de colores --}}
        <div class="flex flex-wrap gap-3 ml-4">
            @php
                $leyenda = [
                    'idea' => '#6B7280', 'desarrollo' => '#3B82F6', 'aprobado' => '#86EFAC',
                    'pendiente_grabar' => '#FDE68A', 'grabado' => '#F97316',
                    'editando' => '#C084FC', 'revision' => '#F472B6',
                    'programado' => '#16A34A', 'publicado' => '#22C55E',
                ];
            @endphp
            @foreach ($leyenda as $estado => $color)
                <span class="flex items-center gap-1 text-xs text-gray-500">
                    <span class="w-2 h-2 rounded-full" style="background-color: {{ $color }}"></span>
                    {{ ucfirst(str_replace('_', ' ', $estado)) }}
                </span>
            @endforeach
        </div>
    </div>

    {{-- Calendario --}}
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-4">
        <div id="calendario-fullcalendar"></div>
    </div>

    {{-- FullCalendar vía CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

    <script>
        let calendarioFC = null;

        function iniciarCalendario(eventos) {
            const el = document.getElementById('calendario-fullcalendar');
            if (!el) return;

            if (calendarioFC) {
                calendarioFC.destroy();
            }

            calendarioFC = new FullCalendar.Calendar(el, {
                initialView: 'dayGridMonth',
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                events: eventos,
                eventClick: function(info) {
                    const contenidoId = info.event.extendedProps.contenido_id;
                    Livewire.dispatch('abrirFicha', { contenidoId: contenidoId });
                },
                themeSystem: 'standard',
                height: 'auto',
            });

            calendarioFC.render();

            // Estilos oscuros para FullCalendar
            const style = document.createElement('style');
            style.textContent = `
                .fc { color: #e5e7eb; }
                .fc-toolbar-title { color: #e5e7eb; font-size: 1rem !important; }
                .fc-button { background: #374151 !important; border-color: #4b5563 !important; color: #e5e7eb !important; }
                .fc-button:hover { background: #4b5563 !important; }
                .fc-button-active { background: #7c3aed !important; border-color: #7c3aed !important; }
                .fc-daygrid-day { background: transparent; }
                .fc-daygrid-day-number { color: #9ca3af; }
                .fc-col-header-cell-cushion { color: #6b7280; font-size: 0.75rem; }
                .fc-scrollgrid { border-color: #1f2937 !important; }
                .fc-scrollgrid-section > td { border-color: #1f2937 !important; }
                .fc-daygrid-day { border-color: #1f2937 !important; }
                .fc-event { cursor: pointer; border: none !important; padding: 2px 4px; font-size: 0.7rem; }
                .fc-day-today { background: rgba(124, 58, 237, 0.08) !important; }
            `;
            document.head.appendChild(style);
        }

        // Inicializar con los eventos del servidor
        document.addEventListener('DOMContentLoaded', function() {
            iniciarCalendario(@json($eventos));
        });

        // Actualizar cuando Livewire cambia la marca
        document.addEventListener('livewire:initialized', function() {
            Livewire.on('eventos-actualizados', function(data) {
                iniciarCalendario(data.eventos);
            });
        });
    </script>
</div>
