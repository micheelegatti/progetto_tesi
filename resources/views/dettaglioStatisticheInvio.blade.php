@extends('app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    {{-- Intestazione --}}
    <div class="flex justify-between items-center">
        <div>
            <div class="text-xs font-semibold text-stone-500 uppercase tracking-wider">Report Sessione d'Invio</div>
            <h1 class="text-2xl font-bold text-stone-900">{{ $invio->campagna->name ?? 'Campagna' }}</h1>
            <p class="text-sm text-stone-500">Oggetto: "{{ $invio->oggetto }}" • Spedito il {{ $invio->created_at->format('d/m/Y H:i') }}</p>
        </div>
        <a href="{{ url()->previous() }}" class="px-4 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 text-sm font-semibold rounded-lg transition">
            ← Torna allo Storico
        </a>
    </div>

    {{-- STATISTICHE GENERICHE: Webhook Principali --}}
    <div>
        <h3 class="text-xs font-semibold text-stone-400 uppercase tracking-wider mb-3">Metriche generali</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white border border-stone-200 rounded-xl p-5 shadow-sm space-y-1">
                <span class="text-xs font-semibold text-stone-500 uppercase tracking-wider">Destinatari Totali</span>
                <div class="text-2xl font-bold text-stone-900">{{ $totali }}</div>
            </div>
            <div class="bg-white border border-stone-200 rounded-xl p-5 shadow-sm space-y-1">
                <span class="text-xs font-semibold text-stone-500 uppercase tracking-wider">Tasso di Consegna</span>
                <div class="text-2xl font-bold text-emerald-600">{{ $deliveryRate }}%</div>
            </div>
            <div class="bg-white border border-stone-200 rounded-xl p-5 shadow-sm space-y-1">
                <span class="text-xs font-semibold text-stone-500 uppercase tracking-wider">Tasso di Apertura</span>
                <div class="text-2xl font-bold text-blue-600">{{ $openRate }}%</div>
            </div>
            <div class="bg-white border border-stone-200 rounded-xl p-5 shadow-sm space-y-1">
                <span class="text-xs font-semibold text-stone-500 uppercase tracking-wider">Tasso di Click</span>
                <div class="text-2xl font-bold text-indigo-600">{{ $clickRate }}%</div>
            </div>
        </div>
    </div>

    {{-- Statistich 2: Webhook negativi: Bouce, Disiscrizioni, Spam --}}
    <div>
        <h3 class="text-xs font-semibold text-stone-400 uppercase tracking-wider mb-3">Reputazione e Feedback Negativi</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white border border-stone-200 rounded-xl p-5 shadow-sm space-y-1">
                <span class="text-xs font-semibold text-stone-500 uppercase tracking-wider">Rimbalzi (Bounces)</span>
                <div class="text-2xl font-bold text-amber-600">{{ $rimbalzati }} <span class="text-sm font-normal text-stone-400">({{ $bounceRate }}%)</span></div>
            </div>
            <div class="bg-white border border-stone-200 rounded-xl p-5 shadow-sm space-y-1">
                <span class="text-xs font-semibold text-stone-500 uppercase tracking-wider">Disiscrizioni (Unsubscribes)</span>
                <div class="text-2xl font-bold text-orange-600">{{ $disiscritti }} <span class="text-sm font-normal text-stone-400">({{ $unsubRate }}%)</span></div>
            </div>
            <div class="bg-white border border-stone-200 rounded-xl p-5 shadow-sm space-y-1">
                <span class="text-xs font-semibold text-stone-500 uppercase tracking-wider">Segnalazioni Spam</span>
                <div class="text-2xl font-bold text-red-600">{{ $spam }} <span class="text-sm font-normal text-stone-400">({{ $spamRate }}%)</span></div>
            </div>
        </div>
    </div>

    {{-- Tabella dei Log di Singolo Destinatario con evidenza Spam / Disiscrizione --}}
    <div class="bg-white border border-stone-200 rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-stone-100">
            <h2 class="text-base font-bold text-stone-900">Log Individuali dei Destinatari</h2>
            <p class="text-xs text-stone-500">Stato dettagliato, interazioni e feedback di spam o disiscrizione.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-stone-50 text-stone-500 text-xs uppercase tracking-wider border-b border-stone-200">
                        <th class="py-3 px-6 font-semibold">Email Destinatario</th>
                        <th class="py-3 px-6 font-semibold">Esito Consegna</th>
                        <th class="py-3 px-6 font-semibold">Apertura</th>
                        <th class="py-3 px-6 font-semibold">Click</th>
                        <th class="py-3 px-6 font-semibold">Spam/Disiscritto</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 text-sm text-stone-700">
                    @forelse($invio->logInvii as $log)
                        <tr class="hover:bg-stone-50/50 transition">
                            <td class="py-4 px-6 font-medium text-stone-900">
                                {{ $log->email_destinatario }}
                            </td>
                            <td class="py-4 px-6">
                                @if($log->esito_consegna === 'consegnato')
                                    <span class="px-2.5 py-1 text-xs font-semibold bg-emerald-50 text-emerald-700 rounded-full">Consegnato</span>
                                @elseif($log->esito_consegna === 'rimbalzato')
                                    <span class="px-2.5 py-1 text-xs font-semibold bg-red-50 text-red-700 rounded-full">Rimbalzato</span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-semibold bg-amber-50 text-amber-700 rounded-full">{{ ucfirst($log->esito_consegna) }}</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                @if($log->is_aperto)
                                    <span class="text-xs font-semibold text-blue-600">✓ Aperto</span>
                                @else
                                    <span class="text-xs text-stone-400">-</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                @if($log->is_cliccato)
                                    <span class="text-xs font-semibold text-indigo-600">✓ Cliccato</span>
                                @else
                                    <span class="text-xs text-stone-400">-</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                @if($log->is_spam)
                                    <span class="px-2.5 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">Segnalato Spam</span>
                                @elseif($log->is_disiscritto)
                                    <span class="px-2.5 py-1 text-xs font-semibold bg-orange-100 text-orange-800 rounded-full">Disiscritto</span>
                                @else
                                    <span class="text-xs text-stone-400">No</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-stone-400 text-sm">
                                Nessun log registrato per questo invio.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection