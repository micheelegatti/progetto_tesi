@extends('destinatari')

@section('contenuto_destinatari')

    {{-- Form di Filtro per Email e Stato --}}
    <form method="GET" action="{{ url('dashboard/destinatari/contatti') }}" class="mb-6 bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 rounded-xl p-4 shadow-sm flex flex-wrap gap-4 items-end">
        <div class="flex-1 min-w-[200px]">
            <label for="email" class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Cerca per Email</label>
            <input type="text" name="email" id="email" value="{{ request('email') }}" placeholder="es. mario_rossi@email.it"
                class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-3 py-1.5 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div class="w-48">
            <label for="stato" class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Filtra per Stato Iscrizione</label>
            <select name="stato" id="stato" 
                class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-3 py-1.5 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Tutti gli stati</option>
                <option value="{{ App\Enum\StatoIscrizione::Iscritto }}" {{ request('stato') === App\Enum\StatoIscrizione::Iscritto ? 'selected' : '' }}>
                    {{ App\Enum\StatoIscrizione::Iscritto }}
                </option>
                <option value="{{ App\Enum\StatoIscrizione::Disiscritto }}" {{ request('stato') === App\Enum\StatoIscrizione::Disiscritto ? 'selected' : '' }}>
                    {{ App\Enum\StatoIscrizione::Disiscritto }}
                </option>
            </select>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-1.5 rounded-lg text-sm font-medium transition shadow-sm">
                Filtra
            </button>
            <a href="{{ url('dashboard/destinatari/contatti') }}" class="px-4 py-1.5 rounded-lg text-sm font-medium border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                Reset
            </a>
        </div>
    </form>

    <div class="mb-4 m-1 text-sm text-gray-700 dark:text-gray-300">
        <p>
            <strong>Totale contatti:</strong> {{ $contatti->count() }} |
            <strong>Iscritti:</strong> {{ $contatti->where('stato', App\Enum\StatoIscrizione::Iscritto)->count() }} |
            <strong>Disiscritti:</strong> {{ $contatti->where('stato', App\Enum\StatoIscrizione::Disiscritto)->count() }}
        </p>
    </div>

    <div class="border border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900/50 rounded-2xl overflow-x-auto shadow-sm">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-200 dark:bg-slate-800/50 dark:border-slate-800 text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                <tr>
                    <th class="p-4 font-semibold">Nome</th>
                    <th class="p-4 font-semibold">Email</th>
                    <th class="p-4 font-semibold">Stato</th>
                    <th class="p-4 font-semibold">Aggiunto il</th>
                    <th class="p-4 text-right font-semibold">Azione</th>
                </tr>
            </thead>
            <tbody class="text-sm text-slate-700 dark:text-slate-300 divide-y divide-slate-200 dark:divide-slate-800">
                
                @forelse($contatti as $contatto)
                    <tr class="hover:bg-slate-50/65 dark:hover:bg-slate-800/50 transition">
                        <td class="p-4 font-medium text-slate-900 dark:text-white">{{ $contatto->nome }} {{ $contatto->cognome }}</td>
                        <td class="p-4 text-slate-500 dark:text-slate-400">{{ $contatto->email }}</td>
                        <td class="p-4">
                           @if($contatto->stato === App\Enum\StatoIscrizione::Iscritto)
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                    {{ $contatto->stato }}
                                </span>
                            @else
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700 dark:bg-amber-900/30 dark:text-amber-400">
                                    {{ $contatto->stato }}
                                </span>
                            @endif
                        </td>
                        <td class="p-4 text-slate-500 dark:text-slate-400">{{ $contatto->created_at->format('d/m/Y') }}</td>
                        <!--Bottoni azioni -->
                        <td class="p-4 text-right space-x-2">
                            {{-- Bottone Modifica --}}
                            <a href="{{ url('dashboard/destinatari/import/' . $contatto->id . '/edit') }}" 
                               class="inline-flex items-center px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-semibold rounded-lg transition">
                                Modifica
                            </a>
                            
                            {{-- Bottone Gestisci Liste  --}}
                            <a href="{{ url('dashboard/destinatari/contatti/' . $contatto->id . '/liste') }}" 
                               class="inline-flex items-center px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-semibold rounded-lg transition">
                                Liste
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-500 dark:text-slate-400">
                            Nessun contatto trovato.
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
@endsection