@extends('app')

@section('breadcrumbs')
    <li>
        <span class="font-semibold text-slate-800 dark:text-slate-200">Nome Pagina</span>
    </li>
     <li>
        <span class="text-slate-300 dark:text-slate-600">/</span>
    </li>
    <li>
        <a href="{{ route('campagna') }}" class="hover:text-[#722e89] dark:hover:text-purple-300 transition">Campagna</a>
    </li>
    
@endsection

@section('content')

<div class="space-y-6">
    
    {{-- INTESTAZIONE DELLA PAGINA --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-stone-900">Le mie campagne</h1>
            <p class="text-sm text-stone-500">Gestisci e monitora l'invio delle tue campagne email</p>
        </div>
        <a href="{{ url('dashboard/campagna/info') }}" class="bg-[#722e89] hover:bg-[#5e2272] text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-sm transition">
            Nuova Campagna
        </a>
    </div>

    {{-- TABELLA DELLE CAMPAGNE --}}
    <div class="border border-stone-200 bg-white rounded-xl overflow-hidden shadow-sm">
        <table class="w-full text-left">
            <thead class="bg-stone-50 border-b border-stone-200 text-xs text-stone-500 uppercase tracking-wider">
                <tr>
                    <th class="p-4 font-semibold">Nome Campagna</th>
                    <th class="p-4 font-semibold">Template Collegato</th>
                    <th class="p-4 font-semibold">Stato</th>
                    <th class="p-4 font-semibold">Creato il</th>
                    <th class="p-4 text-right font-semibold">Azione</th>
                </tr>
            </thead>
            <tbody class="text-sm text-stone-700 divide-y divide-stone-100">
                
                {{-- Ciclo sui dati reali del DB delle campagne --}}
                @forelse($campagne as $campagna)
                    <tr class="hover:bg-stone-50/65 transition">
                        <td class="p-4 font-medium text-stone-900">{{ $campagna->name }}</td>
                        <td class="p-4 text-stone-500">{{ $campagna->template->name ?? 'Nessun template' }}</td>
                        <td class="p-4">
                            {{-- Badge di stato dinamico --}}
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full 
                                @if($campagna->stato === 'sent') bg-emerald-100 text-emerald-700 
                                @elseif($campagna->stato === 'scheduled') bg-blue-100 text-blue-700 
                                @else bg-amber-100 text-amber-700 @endif">
                                {{ ucfirst($campagna->stato->value) }}
                            </span>
                        </td>
                        <td class="p-4 text-stone-500">{{ $campagna->created_at->format('d/m/Y') }}</td>
                        <td class="p-4 text-right space-x-2">
                            <a href="{{ url('dashboard/campagna/' .$campagna->id. '/riepilogo') }}" 
                                class="inline-block bg-stone-100 hover:bg-stone-200/80 text-stone-800 px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                Invia
                            </a>
                            {{-- Bottone Visualizza --}}
                            <a href="{{ url('dashboard/campagna/' . $campagna->id) }}" 
                                class="inline-block bg-stone-100 hover:bg-stone-200/80 text-stone-800 px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                Modifica
                            </a>
                            <form action="{{ url('dashboard/campagna/' . $campagna->id) }}" method="POST" class="inline" 
                                onsubmit="return confirm('{{ 
                                    $campagna->stato === App\Enum\StatoCampagna::InvioProgrammato 
                                        ? 'Attenzione: questa campagna ha un invio programmato. Sei sicuro di volerla eliminare?'
                                        : ($campagna->stato === App\Enum\StatoCampagna::Inviata 
                                            ? 'Attenzione: questa campagna è già stata inviata. Eliminandola perderai tutte le statistiche collegate. Sei sicuro di voler procedere?' 
                                            : 'Sei sicuro di voler eliminare questa bozza?') 
                                }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-2.5 py-1.5 bg-red-50 hover:bg-red-100 dark:bg-red-950/50 dark:hover:bg-red-900/50 text-red-600 dark:text-red-400 text-xs font-semibold rounded-lg transition">
                                    Elimina
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    {{-- Messaggio se il database è vuoto --}}
                    <tr>
                        <td colspan="5" class="p-12 text-center text-stone-400">
                            <div class="text-base font-medium mb-1">Nessuna campagna creata</div>
                            <p class="text-sm">Clicca su "Nuova Campagna" per iniziare a inviare le tue email.</p>
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>

</div>
@endsection