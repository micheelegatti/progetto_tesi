<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @class(['dark' => ($appearance ?? 'system') == 'dark'])>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>{{ config('app.name', 'Softweb Mail') }}</title>
    
    {{-- Script dark mode e sidebar state (invariati) --}}
    <script>
        (function() {
            const appearance = '{{ $appearance ?? "system" }}';
            if (appearance === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    <script>
        (function() {
            if (localStorage.getItem('sidebarState') === 'collapsed') {
                document.documentElement.classList.add('sidebar-collapsed');
            }
        })();
    </script>

    <style>
        html { background-color: oklch(1 0 0); }
        html.dark { background-color: oklch(0.145 0 0); }
        html.sidebar-collapsed #app-sidebar { width: 5rem !important; }
        html.sidebar-collapsed .sidebar-label { display: none !important; }
    </style>

    <link rel="icon" href="/favicon.ico" sizes="any">
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.ts'])
</head>
{{-- h-screen e overflow-hidden bloccano lo scroll della finestra principale --}}
<body class="bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100 font-sans antialiased h-screen flex flex-col overflow-hidden">

    <div id="app-root" class="flex flex-col h-full">
        
        {{-- HEADER FISSO IN ALTO (Non scrolla) --}}
        <header class="h-16 shrink-0 border-b border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900 z-40 flex items-center justify-between px-6 shadow-sm">
            <div class="flex items-center gap-2 shrink-0">
                <img src="{{ asset('logo1.svg') }}" alt="Logo Azienda" class="h-9 w-9 object-contain">
                <span class="text-lg font-bold tracking-tight text-slate-900 dark:text-white">Softweb<span class="text-[#722e89]">Mail</span></span>
            </div>
            <div class="flex items-center gap-4 shrink-0">
                <span class="text-sm font-semibold text-slate-700 dark:text-white">{{ auth()->user()->name ?? 'Utente Admin' }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="px-3 py-1.5 text-sm font-medium text-slate-600 hover:text-[#722e89] dark:text-slate-400 dark:hover:text-white bg-slate-100 hover:bg-[#f3e8f7] dark:bg-slate-800 dark:hover:bg-[#2a1033] rounded-lg transition">
                        Esci
                    </button>
                </form>
            </div>
        </header>

        {{-- CONTENITORE SOTTO L'HEADER (Bloccato all'altezza dello schermo rimanente) --}}
        <div class="flex flex-1 overflow-hidden h-[calc(100vh-4rem)]">
            
            {{-- SIDEBAR CON SCROLL INDIPENDENTE (Se il menu è lungo) --}}
            <aside id="app-sidebar" 
                   class="w-56 border-r border-slate-200 bg-slate-50/50 dark:border-slate-800 dark:bg-slate-900/30 flex flex-col p-4 hidden md:flex h-full overflow-y-auto transition-all duration-300 ease-in-out shrink-0">
                
                <div class="flex items-center justify-between mb-4 px-1 shrink-0">
                    <span class="sidebar-label text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider truncate">
                        Menu Principale
                    </span>
                    <button onclick="toggleSidebar()" 
                            class="p-2 rounded-xl text-slate-500 hover:bg-purple-100 dark:hover:bg-slate-800 transition mx-auto"
                            title="Riduci/Espandi menu">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <nav class="space-y-1.5">
                    @if(isset($menuItems))
                        @foreach($menuItems as $item)
                            <a href="{{ route($item->route) }}" 
                               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition duration-150 
                               {{ Route::is($item->route) ? 'bg-[#f3e8f7] text-[#722e89] dark:bg-purple-950/40 dark:text-purple-200' : 'text-slate-600 hover:bg-slate-200/50 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800/50 dark:hover:text-white' }}"
                               title="{{ $item->title }}">
                                
                                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item->icon }}" />
                                </svg>

                                <span class="sidebar-label whitespace-nowrap overflow-hidden transition-opacity duration-200">
                                    {{ $item->title }}
                                </span>
                            </a>
                        @endforeach
                    @endif
                </nav>
            </aside>

            {{-- ZONA CONTENUTO: È L'UNICA A SCORRERE E LA BARRA PARTE SOTTO L'HEADER --}}
            <main class="flex-1 h-full overflow-y-auto p-6 md:p-8 bg-slate-50 dark:bg-slate-950">
                
                {{-- Breadcrumbs --}}
                @hasSection('breadcrumbs')
                    <nav class="mb-3" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-2 text-xs md:text-sm text-slate-500 dark:text-slate-400">
                            @yield('breadcrumbs')
                        </ol>
                    </nav>
                @endif

                @yield('content')
            </main>

        </div>
    </div>

    <script>
        function toggleSidebar() {
            const html = document.documentElement;
            html.classList.toggle('sidebar-collapsed');
            const isCollapsed = html.classList.contains('sidebar-collapsed');
            localStorage.setItem('sidebarState', isCollapsed ? 'collapsed' : 'expanded');
        }
    </script>
</body>
</html>