@extends('destinatari') 

@section('contenuto_destinatari')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-xl font-bold text-slate-900 dark:text-white">Gestione Liste</h1>
        <p class="text-sm text-slate-500">Visualizza e gestisci le tue liste di contatti.</p>
    </div>
    
    {{-- Bottone per creare una nuova lista --}}
    <a href="#" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
        + Crea Nuova Lista
    </a>
</div>

<div class="border border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900/50 rounded-lg overflow-hidden shadow-sm">
    <table class="w-full text-left border-collapse">
        <thead class="bg-slate-50 border-b border-slate-200 dark:border-slate-800 dark:bg-slate-800">
            <tr>
                <th class="p-4 text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase">ID</th>
                <th class="p-4 text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase">Nome Lista</th>
                <th class="p-4 text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase">Num. Iscritti</th>
                <th class="p-4 text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase">Num. Disiscritti</th>
                <th class="p-4 text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase text-right">Azioni</th>
            </tr>
        </thead>
        <tbody class="text-sm text-slate-700 dark:text-slate-300 divide-y divide-slate-200 dark:divide-slate-800">
            @forelse($liste as $lista)
                <tr class="hover:bg-slate-50/65 dark:hover:bg-slate-800/50 transition">
                    <td class="p-4 font-medium text-slate-900 dark:text-white">{{ $lista->id }}</td>
                    <td class="p-4 font-medium text-slate-900 dark:text-white">{{ $lista->nome }}</td>
                    <td class="p-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                            {{ $lista->iscritti_count }}
                        </span>
                    </td>
                    <td class="p-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                            {{ $lista->disiscritti_count }}
                        </span>
                    </td>
                    <td class="p-4 text-right">
                        <a href="#" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 font-medium">Modifica</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-6 text-center text-slate-500">Nessuna lista trovata.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection