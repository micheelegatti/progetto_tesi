@extends('default')

@section('content')
<div class="space-y-6">
    
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-white">Lista Campagne</h1>
            <p class="text-sm text-slate-400">Qui vedi le tue campagne di invio.</p>
        </div>
        <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
            Nuova Campagna
        </a>
    </div>

    <div class="border border-slate-800 bg-slate-900/50 rounded-xl overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-900 border-b border-slate-800 text-xs text-slate-400 uppercase">
                <tr>
                    <th class="p-4">Nome</th>
                    <th class="p-4">Stato</th>
                    <th class="p-4 text-right">Azione</th>
                </tr>
            </thead>
            <tbody class="text-sm text-slate-200 divide-y divide-slate-850">
                <tr>
                    <td class="p-4 font-medium">Promo Estate 2026</td>
                    <td class="p-4 text-emerald-400">Inviata</td>
                    <td class="p-4 text-right">
                        <a href="#" class="text-blue-400 hover:underline">Vedi</a>
                    </td>
                </tr>
                <tr>
                    <td class="p-4 font-medium">Newsletter Black Friday</td>
                    <td class="p-4 text-amber-400">Bozza</td>
                    <td class="p-4 text-right">
                        <a href="#" class="text-blue-400 hover:underline">Modifica</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
@endsection