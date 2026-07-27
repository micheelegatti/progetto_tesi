@extends('destinatari') 

@section('contenuto_destinatari')
<div class="mb-6">
    <h1 class="text-xl font-bold text-slate-900 dark:text-white">Nuova Lista / Contatti</h1>
    <p class="text-sm text-slate-500">Scegli in che modo desideri aggiungere i contatti alla nuova lista.</p>
</div>

{{-- Griglia dei riquadri in stile MailUp --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mt-8">
    
    {{-- Riquadro 1: Singolo Destinatario --}}
    <a href="{{ url('dashboard/destinatari/import/contatto') }}" class="group border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/50 rounded-xl p-8 text-center hover:border-indigo-600 dark:hover:border-indigo-500 hover:shadow-md transition flex flex-col items-center justify-center">
        <div class="w-16 h-16 bg-indigo-50 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition">
            {{-- Icona Utente --}}
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
        </div>
        <h2 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">Singolo destinatario</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400">Inserisci manualmente i dati di un singolo contatto e salvalo nella lista.</p>
    </a>

    {{-- Riquadro 2: Importa file CSV --}}
    <a href="#" class="group border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/50 rounded-xl p-8 text-center hover:border-indigo-600 dark:hover:border-indigo-500 hover:shadow-md transition flex flex-col items-center justify-center">
        <div class="w-16 h-16 bg-indigo-50 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition">
            {{-- Icona File/Documento --}}
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
        </div>
        <h2 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">Importa file CSV</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400">Carica un file in formato CSV per importare massivamente i contatti.</p>
    </a>

</div>
@endsection