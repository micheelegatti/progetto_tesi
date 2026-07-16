<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Softweb mail</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased min-h-screen flex flex-col">

    <header class="h-16 border-b border-slate-800 bg-slate-900/50 backdrop-blur sticky top-0 z-40 flex items-center justify-between px-6">
        <div class="flex items-center gap-3">
            <div class="h-9 w-9 rounded-lg bg-blue-600 flex items-center justify-center font-bold text-white shadow-lg shadow-blue-500/20">
                P
            </div>
            <span class="text-lg font-bold tracking-tight text-white">
                Softweb<span class="text-blue-500">Mail</span>
            </span>
        </div>

        <div class="flex items-center gap-4">
            <div class="flex items-center gap-3 border-l border-slate-800 pl-4">
                <div class="text-right">
                    <p class="text-sm font-semibold text-white">{{ auth()->user()->name ?? 'Utente Admin' }}</p>
                    <p class="text-xs text-slate-500">admin</p>
                </div>
            </div>
        </div>
    </header>

    <div class="flex flex-1">
        <aside class="w-64 border-r border-slate-800 bg-slate-900/30 flex flex-col justify-between p-4 hidden md:flex">
            <nav class="space-y-1">
                <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Menu Principale</p>
                @foreach($menuItems as $item)
                    {{-- Genera l'URL corretto usando il nome della rotta salvato nel database --}}
                    <a href="{{ route($item->route) }}" 
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition duration-150 
                    {{ Route::is($item->route) ? 'bg-slate-800/80 text-white' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                        
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        
                        {{ $item->title }}
                    </a>
                @endforeach
            </nav>

            <div class="border-t border-slate-800 pt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-rose-400 hover:bg-rose-950/20 hover:text-rose-300 transition duration-150 text-left">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        Disconnetti
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 p-6 md:p-8 overflow-y-auto">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-white tracking-tight">Pannello di Controllo</h2>
                <p class="text-slate-400 text-sm mt-1">Benvenuto nel pannello di PostaHub. Qui trovi il resoconto delle tue attività.</p>
            </div>

            <div class="grid gap-6 md:grid-cols-3 mb-8">
                <div class="rounded-xl border border-slate-800 bg-slate-900/40 p-6">
                    <p class="text-sm font-medium text-slate-400">Newsletter Inviate</p>
                    <p class="text-3xl font-extrabold text-white mt-2">24</p>
                    <span class="text-xs text-blue-400 font-medium mt-1 inline-block">Prossimo invio programmato: Domani</span>
                </div>

                <div class="rounded-xl border border-slate-800 bg-slate-900/40 p-6">
                    <p class="text-sm font-medium text-slate-400">Iscritti Attivi</p>
                    <p class="text-3xl font-extrabold text-white mt-2">1,482</p>
                    <span class="text-xs text-emerald-400 font-medium mt-1 inline-block">↑ 12% nell'ultimo mese</span>
                </div>

                <div class="rounded-xl border border-slate-800 bg-slate-900/40 p-6">
                    <p class="text-sm font-medium text-slate-400">Tasso Medio di Apertura</p>
                    <p class="text-3xl font-extrabold text-white mt-2">64.2%</p>
                    <span class="text-xs text-purple-400 font-medium mt-1 inline-block">Ottimo coinvolgimento</span>
                </div>
            </div>

            <div id="app" class="rounded-xl border border-slate-800 bg-slate-900/20 p-6 min-h-[300px]">
                <h3 class="text-lg font-semibold text-white mb-4">Attività Recenti</h3>
                
                <div class="border border-dashed border-slate-800 rounded-lg h-48 flex items-center justify-center text-slate-500 text-sm">
                    In questa sezione monteremo una Tabella di PrimeVue per tracciare lo stato delle newsletter.
                </div>
            </div>
        </main>
    </div>

</body>
</html>