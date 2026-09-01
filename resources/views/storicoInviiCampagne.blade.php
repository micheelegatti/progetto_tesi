@extends('app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    {{-- Intestazione --}}
    <div>
        <h1 class="text-2xl font-bold text-stone-900">Storico e Statistiche Invii</h1>
        <p class="text-sm text-stone-500">Panoramica globale delle sessioni di spedizione e delle metriche di performance.</p>
    </div>

    {{-- 1. KPI Cards in alto (Box riassuntivi) --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        
        <div class="bg-white border border-stone-200 rounded-xl p-5 shadow-sm space-y-1">
            <span class="text-xs font-semibold text-stone-500 uppercase tracking-wider">Totale Inviati</span>
            <div class="text-2xl font-bold text-stone-900">{{ $totaleInviati ?? '12,450' }}</div>
        </div>

        <div class="bg-white border border-stone-200 rounded-xl p-5 shadow-sm space-y-1">
            <span class="text-xs font-semibold text-stone-500 uppercase tracking-wider">Tasso Apertura Medio</span>
            <div class="text-2xl font-bold text-stone-900">{{ $openRateMedio ?? '42.5%' }}</div>
        </div>

        <div class="bg-white border border-stone-200 rounded-xl p-5 shadow-sm space-y-1">
            <span class="text-xs font-semibold text-stone-500 uppercase tracking-wider">Tasso Click Medio</span>
            <div class="text-2xl font-bold text-stone-900">{{ $clickRateMedio ?? '12.1%' }}</div>
        </div>

        <div class="bg-white border border-stone-200 rounded-xl p-5 shadow-sm space-y-1">
            <span class="text-xs font-semibold text-stone-500 uppercase tracking-wider">Rimbalzi (Bounces)</span>
            <div class="text-2xl font-bold text-red-600">{{ $rimbalziTotali ?? '1.2%' }}</div>
        </div>

    </div>

    {{-- 2. Tabella Storico Invii --}}
    <div class="bg-white border border-stone-200 rounded-xl shadow-sm overflow-hidden">
        
        <div class="p-6 border-b border-stone-100 flex justify-between items-center">
            <h2 class="text-base font-bold text-stone-900">Sessioni di Spedizione Recenti</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-stone-50 text-stone-500 text-xs uppercase tracking-wider border-b border-stone-200">
                        <th class="py-3 px-6 font-semibold">Campagna / Oggetto</th>
                        <th class="py-3 px-6 font-semibold">Data Invio</th>
                        <th class="py-3 px-6 font-semibold">Destinatari</th>
                        <th class="py-3 px-6 font-semibold">Consegna</th>
                        <th class="py-3 px-6 font-semibold text-right">Azioni</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 text-sm text-stone-700">
                    @forelse($invii as $invio)
                        <tr class="hover:bg-stone-50/50 transition">
                            <td class="py-4 px-6">
                                <div class="font-medium text-stone-900">{{ $invio->campagna->name ?? 'Campagna rimossa' }}</div>
                                <div class="text-xs text-stone-500 truncate max-w-xs">{{ $invio->oggetto }}</div>
                            </td>
                            <td class="py-4 px-6 text-stone-500">
                                {{ $invio->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="py-4 px-6 font-medium">
                                {{ $invio->log_invii_count }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 text-xs font-semibold bg-emerald-50 text-emerald-700 rounded-full">
                                    {{ $invio->tasso_consegna }}%
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a 
                                    href="{{ url('dashboard/statistiche/' . $invio->id) }}" 
                                    class="inline-flex items-center px-3 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-700 text-xs font-semibold rounded-lg transition"
                                >
                                    Visualizza Report
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-stone-400 text-sm">
                                Nessun invio effettuato finora.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>
@endsection