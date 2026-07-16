@extends('default')

@section('content')
<div class="space-y-6">
    
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-white">I Miei Template</h1>
            <p class="text-sm text-slate-400">Gestisci i modelli grafici per le tue email.</p>
        </div>
        <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
            Nuovo Template
        </a>
    </div>

    <div class="border border-slate-800 bg-slate-900/50 rounded-xl overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-900 border-b border-slate-800 text-xs text-slate-400 uppercase">
                <tr>
                    <th class="p-4">Nome Modello</th>
                    <th class="p-4">Ultima Modifica</th>
                    <th class="p-4 text-right">Azione</th>
                </tr>
            </thead>
            <tbody class="text-sm text-slate-200 divide-y divide-slate-850">
                <tr>
                    <td class="p-4 font-medium">Template Benvenuto Standard</td>
                    <td class="p-4 text-slate-400">10 Luglio 2026</td>
                    <td class="p-4 text-right">
                        <a href="#" class="text-blue-400 hover:underline">Usa</a>
                    </td>
                </tr>
                <tr>
                    <td class="p-4 font-medium">Layout Promozionale Minimal</td>
                    <td class="p-4 text-slate-400">02 Giugno 2026</td>
                    <td class="p-4 text-right">
                        <a href="#" class="text-blue-400 hover:underline">Modifica</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
@endsection