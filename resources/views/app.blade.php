<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @class(['dark' => ($appearance ?? 'system') == 'dark'])>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>{{ config('app.name', 'Softweb Mail') }}</title>
    
    {{-- Script per la dark mode --}}
    <script>
        (function() {
            const appearance = '{{ $appearance ?? "system" }}';

            if (appearance === 'system') {
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                if (prefersDark) {
                    document.documentElement.classList.add('dark');
                }
            }
        })();
    </script>

    {{-- Stili per il background (Prevengono i flash bianchi al caricamento) --}}
    <style>
        html {
            background-color: oklch(1 0 0);
        }

        html.dark {
            background-color: oklch(0.145 0 0);
        }
    </style>

    {{-- Favicon e icone dello Starter Kit --}}
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    {{-- Direttiva font dello Starter Kit --}}
    @fonts

    {{-- Compilazione Vite: Carica gli stili globali e il tuo inizializzatore Vue --}}
    @vite(['resources/css/app.css', 'resources/js/app.ts'])
</head>
<body class="bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100 font-sans antialiased min-h-screen flex flex-col transition-colors duration-150">

    {{-- CORPO DELL'APPLICAZIONE VUE: Tutto quello che c'è qui dentro supporta Vue e PrimeVue --}}
    <div id="app-root" class="flex flex-col flex-1 min-h-screen">
        
        {{-- HEADER SUPERIORE --}}
        <header class="h-16 border-b border-slate-200 bg-white/80 dark:border-slate-800 dark:bg-slate-900/50 backdrop-blur sticky top-0 z-40 flex items-center justify-between px-6">
            <div class="flex items-center gap-2">
                <img src="{{ asset('logo1.svg') }}" alt="Logo Azienda" class="h-9 w-9 object-contain">
                <span class="text-lg font-bold tracking-tight text-slate-900 dark:text-white">Softweb<span class="text-[#722e89]">Mail</span></span>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-sm font-semibold text-slate-700 dark:text-white">{{ auth()->user()->name ?? 'Utente Admin' }}</span>
                {{-- Form  --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="px-3 py-1.5 text-sm font-medium text-slate-600 hover:text-[#722e89] dark:text-slate-400 dark:hover:text-white bg-slate-100 hover:bg-[#f3e8f7] dark:bg-slate-800 dark:hover:bg-[#2a1033] rounded-lg transition">
                        Esci
                    </button>
                </form>
            </div>
        </header>

        {{-- CONTENITORE PRINCIPALE (SIDEBAR + CONTENUTO) --}}
        <div class="flex flex-1">
            
            {{-- SIDEBAR DI NAVIGAZIONE --}}
            <aside class="w-64 border-r border-slate-200 bg-slate-50/50 dark:border-slate-800 dark:bg-slate-900/30 flex flex-col p-4 hidden md:flex sticky top-16 h-[calc(100vh-4rem)] overflow-y-auto">
                <nav class="space-y-1">
                    <p class="px-3 text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-3">Menu Principale</p>
                    
                    @if(isset($menuItems))
                        @foreach($menuItems as $item)
                            <a href="{{ route($item->route) }}" 
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition duration-150 
                            {{ Route::is($item->route) ? 'bg-slate-200/80 text-slate-900 dark:bg-slate-800/80 dark:text-white' : 'text-slate-600 hover:bg-slate-200/50 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800/50 dark:hover:text-white' }}">
                                
                                {{-- Icona dinamica associata alla voce di menu --}}
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item->icon }}" />
                                </svg>

                                {{ $item->title }}
                            </a>
                        @endforeach
                    @endif
                </nav>
            </aside>

            {{-- ZONA CONTENUTO DINAMICO --}}
            <main class="flex-1 p-6 md:p-8 overflow-y-auto">
                @yield('content')
            </main>

        </div>
    </div>

</body>
</html>