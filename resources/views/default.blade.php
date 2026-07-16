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
            <div class="h-9 w-9 rounded-lg bg-blue-600 flex items-center justify-center font-bold text-white shadow-lg shadow-blue-500/20">P</div>
            <span class="text-lg font-bold tracking-tight text-white">Softweb<span class="text-blue-500">Mail</span></span>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-sm font-semibold text-white">{{ auth()->user()->name ?? 'Utente Admin' }}</span>
        </div>
    </header>

    <div class="flex flex-1" id="app">
        
        <aside class="w-64 border-r border-slate-800 bg-slate-900/30 flex flex-col justify-between p-4 hidden md:flex">
            <nav class="space-y-1">
                <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Menu Principale</p>
                @foreach($menuItems as $item)
                    {{-- Navigazione classica di Laravel --}}
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
        </aside>


        <!--Qua andranno a posizionarsi i file che estendono il questo file-->
        <main class="flex-1 p-6 md:p-8 overflow-y-auto">
            @yield('content')
        </main>
    </div>

</body>
</html>