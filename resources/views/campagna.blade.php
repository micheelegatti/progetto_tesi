@extends('app')

@section('content')
<div class="space-y-6">
    
    {{-- INTESTAZIONE DELLA PAGINA --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-stone-900">Lista Campagne</h1>
            <p class="text-sm text-stone-500">Qui vedi le tue campagne di invio.</p>
        </div>
        <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-sm transition">
            Nuova Campagna
        </a>
    </div>

    {{-- TABELLA DELLE CAMPAGNE --}}
    <div class="border border-stone-200 bg-white rounded-xl overflow-hidden shadow-sm">
        <table class="w-full text-left">
            <thead class="bg-stone-50 border-b border-stone-200 text-xs text-stone-500 uppercase tracking-wider">
                <tr>
                    <th class="p-4 font-semibold">Nome</th>
                    <th class="p-4 font-semibold">Stato</th>
                    <th class="p-4 text-right font-semibold">Azione</th>
                </tr>
            </thead>
            <tbody class="text-sm text-stone-700 divide-y divide-stone-100">
                
                {{-- Riga 1: Campagna Inviata --}}
                <tr class="hover:bg-stone-50/60 transition">
                    <td class="p-4 font-medium text-stone-900">Promo Estate 2026</td>
                    <td class="p-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                            Inviata
                        </span>
                    </td>
                    <td class="p-4 text-right">
                        <a href="#" class="inline-block bg-stone-100 hover:bg-stone-200/80 text-stone-800 px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                            Vedi
                        </a>
                    </td>
                </tr>

                {{-- Riga 2: Campagna Bozza --}}
                <tr class="hover:bg-stone-50/60 transition">
                    <td class="p-4 font-medium text-stone-900">Newsletter Black Friday</td>
                    <td class="p-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">
                            Bozza
                        </span>
                    </td>
                    <td class="p-4 text-right">
                        <a href="#" class="inline-block bg-stone-100 hover:bg-stone-200/80 text-stone-800 px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                            Modifica
                        </a>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

</div>
@endsection