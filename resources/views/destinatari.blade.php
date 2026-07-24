@extends('app')

@section('content')
<div class="space-y-6">
    
    {{-- INTESTAZIONE DELLA PAGINA --}}
    <div class="flex flex-col gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Destinatari Newsletter</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Gestisci i contatti, organizza le liste ed effettua importazioni</p>
        </div>

        {{-- SUB-MENU A BLOCCO (Segmented Control) --}}
        <div class="flex items-center gap-1.5 p-1 bg-slate-100 dark:bg-slate-900/80 rounded-xl w-fit border border-slate-200/80 dark:border-slate-800">
            <a href="{{ url('dashboard/destinatari/contatti') }}" 
                class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-150 {{ request()->routeIs('recipients.index') ? 'bg-white text-slate-900 shadow-sm dark:bg-slate-800 dark:text-white' : 'text-slate-600 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white' }}">
                Contatti
            </a>
            
            <a href="{{ url('dashboard/destinatari/liste') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-150 {{ request()->routeIs('recipients.lists') ? 'bg-white text-slate-900 shadow-sm dark:bg-slate-800 dark:text-white' : 'text-slate-600 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white' }}">
                Liste
            </a>
                
            <a href="{{ url('dashboard/destinatari/import') }}" 
                class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-150 {{ request()->routeIs('recipients.import') ? 'bg-white text-slate-900 shadow-sm dark:bg-slate-800 dark:text-white' : 'text-slate-600 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white' }}">
                Importa
            </a>
        </div>
    </div>

    {{-- ZONA CONTENUTO DINAMICO --}}
    <div>
        @yield('contenuto_destinatari')
    </div>

</div>
@endsection