@extends('app')

@section('content')
<div class="space-y-6">
    
    {{-- INTESTAZIONE DELLA PAGINA --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-stone-900">I Miei Template</h1>
            <p class="text-sm text-stone-500">Gestisci i modelli grafici per le tue email</p>
        </div>
        <a href="/dashboard/template/crea" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-sm transition">
            Nuovo Template
        </a>
    </div>

    {{-- TABELLA DEI TEMPLATE --}}
    <div class="border border-stone-200 bg-white rounded-xl overflow-hidden shadow-sm">
        <table class="w-full text-left">
            <thead class="bg-stone-50 border-b border-stone-200 text-xs text-stone-500 uppercase tracking-wider">
                <tr>
                    <th class="p-4 font-semibold">Nome Modello</th>
                    <th class="p-4 font-semibold">Creato il</th>
                    <th class="p-4 text-right font-semibold">Azione</th>
                </tr>
            </thead>
            <tbody class="text-sm text-stone-700 divide-y divide-stone-100">
                
                {{-- Ciclo sui dati reali del DB --}}
                @forelse($templates as $template)
                    <tr class="hover:bg-stone-50/60 transition">
                        <td class="p-4 font-medium text-stone-900">{{ $template->name }}</td>
                        <td class="p-4 text-stone-500">{{ $template->created_at->format('d/m/Y') }}</td>
                        <td class="p-4 text-right">
                            {{-- Bottone Modifica: Sfondo grigio/pietra chiaro con testo scuro --}}
                            <a href="{{ url('dashboard/template/' . $template->id . '/modifica') }}" 
                                class="inline-block bg-stone-100 hover:bg-stone-200/80 text-stone-800 px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                Modifica
                            </a>
                        </td>
                    </tr>
                @empty
                    {{-- Messaggio se il database è vuoto --}}
                    <tr>
                        <td colspan="3" class="p-12 text-center text-stone-400">
                            <div class="text-base font-medium mb-1">Nessun template salvato</div>
                            <p class="text-sm">Clicca su "Nuovo Template" per iniziare a creare il tuo primo modello</p>
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>

</div>
@endsection