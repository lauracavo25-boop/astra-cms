<!DOCTYPE html>
<html lang="es" class="h-full bg-gray-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASTRA CMS · @yield('titulo', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="h-full font-sans antialiased text-gray-100">

<div class="flex h-screen overflow-hidden">

    {{-- Sidebar --}}
    <aside class="w-64 bg-gray-900 border-r border-gray-800 flex flex-col shrink-0">

        {{-- Logo --}}
        <div class="h-16 flex items-center px-6 border-b border-gray-800">
            <span class="text-xl font-bold tracking-widest text-violet-400">ASTRA</span>
            <span class="ml-2 text-xs text-gray-500 uppercase tracking-widest">CMS</span>
        </div>

        {{-- Navegación --}}
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            @php
                $nav = [
                    ['route' => 'dashboard',       'label' => 'Dashboard',    'icon' => '▣'],
                    ['route' => 'marcas.index',     'label' => 'Marcas',       'icon' => '◈'],
                    ['route' => 'contenidos.index', 'label' => 'Contenidos',   'icon' => '◉'],
                    ['route' => 'calendario.index', 'label' => 'Calendario',   'icon' => '◫'],
                    ['route' => 'produccion.index', 'label' => 'Producción',   'icon' => '◎'],
                    ['route' => 'edicion.index',    'label' => 'Edición',      'icon' => '◐'],
                    ['route' => 'publicacion.index','label' => 'Publicación',  'icon' => '◑'],
                    ['route' => 'reportes.index',   'label' => 'Reportes',     'icon' => '◒'],
                ];
            @endphp

            @foreach ($nav as $item)
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors
                          {{ request()->routeIs($item['route']) || request()->routeIs(str_replace('.index', '.*', $item['route']))
                              ? 'bg-violet-900/50 text-violet-300 font-medium'
                              : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100' }}">
                    <span class="text-base">{{ $item['icon'] }}</span>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        {{-- Usuario --}}
        <div class="p-4 border-t border-gray-800">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-violet-700 flex items-center justify-center text-xs font-bold">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium truncate">{{ auth()->user()->name ?? 'Usuario' }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email ?? '' }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="submit" class="w-full text-left text-xs text-gray-500 hover:text-red-400 transition-colors">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </aside>

    {{-- Contenido principal --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Header --}}
        <header class="h-16 bg-gray-900 border-b border-gray-800 flex items-center justify-between px-6 shrink-0">
            <h1 class="text-lg font-semibold text-gray-100">@yield('titulo', 'Dashboard')</h1>
            <div class="flex items-center gap-4">
                <span class="text-xs text-gray-500">{{ now()->format('d/m/Y') }}</span>
            </div>
        </header>

        {{-- Flash messages --}}
        @if (session('exito'))
            <div class="mx-6 mt-4 px-4 py-3 rounded-lg bg-green-900/50 border border-green-700 text-green-300 text-sm">
                {{ session('exito') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mx-6 mt-4 px-4 py-3 rounded-lg bg-red-900/50 border border-red-700 text-red-300 text-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- Área de contenido --}}
        <main class="flex-1 overflow-y-auto p-6">
            @yield('contenido')
        </main>
    </div>
</div>

@livewireScripts
</body>
</html>
