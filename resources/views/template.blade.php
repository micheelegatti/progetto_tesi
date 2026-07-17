@extends('default')

@section('content')
<div class="space-y-6">
    
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-white">I Miei Template</h1>
            <p class="text-sm text-slate-400">Gestisci i modelli grafici per le tue email.</p>
        </div>
        <a href="/dashboard/template/crea" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
            Nuovo Template
        </a>
    </div>

    <div class="border border-slate-800 bg-slate-900/50 rounded-xl overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-900 border-b border-slate-800 text-xs text-slate-400 uppercase">
                <tr>
                    <th class="p-4">Nome Modello</th>
                    <th class="p-4">Creato il</th>
                    <th class="p-4 text-right">Azione</th>
                </tr>
            </thead>
            <tbody class="text-sm text-slate-200 divide-y divide-slate-800/50">
                
                {{-- Ciclo sui dati reali del DB --}}
                @forelse($templates as $template)
                    <tr class="hover:bg-slate-900/20 transition">
                        <td class="p-4 font-medium text-white">{{ $template->name }}</td>
                        <td class="p-4 text-slate-400">{{ $template->created_at->format('d/m/Y') }}</td>
                        <td class="p-4 text-right">
                            {{-- Bottone Modifica: manderà alla rotta di modifica passando l'ID --}}
                            <a href="{{ route('template.edit', $template->id) }}" class="inline-block bg-slate-800 hover:bg-slate-700 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                Modifica
                            </a>
                        </td>
                    </tr>
                @empty
                    {{-- Messaggio se il database è vuoto --}}
                    <tr>
                        <td colspan="3" class="p-8 text-center text-slate-500">
                            Nessun template salvato. Clicca su "Nuovo Template" per iniziare.
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>

</div>
@endsection