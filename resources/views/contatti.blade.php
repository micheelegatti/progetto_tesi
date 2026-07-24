@extends('destinatari')

@section('contenuto_destinatari')
<div class="mb-4 m-1 text-sm text-gray-700">
        <p>
            <strong>Totale contatti:</strong> {{ $contatti->count() }} |
            <strong>Iscritti:</strong> {{ $contatti->where('stato', App\Enum\StatoIscrizione::Iscritto)->count() }} |
            <strong>Disiscritti:</strong> {{ $contatti->where('stato', App\Enum\StatoIscrizione::Disiscritto)->count() }}
        </p>
    </div>
<div class="border border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900/50 rounded-2xl overflow-hidden shadow-sm">
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
                    <td class="p-4 text-right space-x-2">
                        <a href="#" class="inline-block bg-slate-100 hover:bg-slate-200/80 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                            Modifica
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