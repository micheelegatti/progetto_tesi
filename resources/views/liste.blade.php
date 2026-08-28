@extends('destinatari') 

@section('contenuto_destinatari')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-xl font-bold text-slate-900 dark:text-white">Gestione Liste</h1>
        <p class="text-sm text-slate-500">Visualizza e gestisci le tue liste di contatti.</p>
    </div>
    
    {{-- Bottone per creare una nuova lista --}}
    <a href="{{ url('dashboard/destinatari/liste/crea') }}" class="bg-[#722e89] hover:bg-[#5e2272] text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
        + Crea Nuova Lista
    </a>
</div>

<div class="border border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900/50 rounded-lg overflow-hidden shadow-sm">
    <table class="w-full table-fixed text-left border-collapse">
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
                    <td class="p-4 text-right space-x-2 flex items-center justify-end">
                        {{-- Bottone Modifica --}}
                        <a href="{{ url('dashboard/destinatari/liste/' . $lista->id . '/edit') }}" 
                        class="inline-flex items-center px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-semibold rounded-lg transition">
                            Modifica
                        </a>
                        
                        {{-- Form ed eliminazione (di fianco) --}}
                        <form action="{{ url('dashboard/destinatari/liste/' . $lista->id) }}" method="POST" class="inline" onsubmit="return confirm('Sei sicuro di voler eliminare questa lista?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="inline-flex items-center px-2.5 py-1.5 bg-red-50 hover:bg-red-100 dark:bg-red-950/50 dark:hover:bg-red-900/50 text-red-600 dark:text-red-400 text-xs font-semibold rounded-lg transition">
                                Elimina
                            </button>
                        </form>
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