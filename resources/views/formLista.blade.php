@extends('destinatari') 

@section('contenuto_destinatari')
<div class="mb-6">
    <h1 class="text-xl font-bold text-slate-900 dark:text-white">
        {{ isset($lista) ? 'Modifica Lista' : 'Crea Nuova Lista' }}
    </h1>
    <p class="text-sm text-slate-500">
        {{ isset($lista) ? 'Modifica i dati e gestisci i contatti associati.' : 'Inserisci i dettagli e seleziona i contatti da aggiungere.' }}
    </p>
</div>

<div class="max-w-3xl bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6 shadow-sm">
    <form action="{{ isset($lista) ? url('dashboard/destinatari/liste/' .$lista->id) : url('dashboard/destinatari/liste') }}" method="POST">
        @csrf
        @if(isset($lista))
            @method('PUT')
        @endif

        {{-- Nome Lista --}}
        <div class="mb-4">
            <label for="nome" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nome Lista</label>
            <input type="text" name="nome" id="nome" value="{{ old('nome', $lista->nome ?? '') }}" required
                class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-3 py-2 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @error('nome')
                <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        {{-- Descrizione --}}
        <div class="mb-6">
            <label for="descrizione" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Descrizione (Opzionale)</label>
            <textarea name="descrizione" id="descrizione" rows="2"
                class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-3 py-2 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('descrizione', $lista->descrizione ?? '') }}</textarea>
            @error('descrizione')
                <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        {{-- Selezione Contatti (Aggiungi / Togli) --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Seleziona Contatti</label>
            <div class="border border-slate-200 dark:border-slate-800 rounded-lg max-h-60 overflow-y-auto divide-y divide-slate-200 dark:divide-slate-800 bg-slate-50/50 dark:bg-slate-900">
                @forelse($destinatari as $destinatario)
                    <label class="flex items-center justify-between px-4 py-3 hover:bg-slate-100 dark:hover:bg-slate-800/50 cursor-pointer transition">
                        <div class="flex items-center">
                            <input type="checkbox" name="destinatari[]" value="{{ $destinatario->id }}"
                                {{ in_array($destinatario->id, old('destinatari', $contattiSelezionati ?? [])) ? 'checked' : '' }}
                                class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                            <div class="ml-3 text-sm text-slate-900 dark:text-white">
                                <span class="font-medium">{{ $destinatario->nome }} {{ $destinatario->cognome }}</span>
                                <span class="text-slate-400 text-xs ml-2">({{ $destinatario->email }})</span>
                            </div>
                        </div>
                        <div>
                            @if($destinatario->stato === App\Enum\StatoIscrizione::Iscritto)
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                    {{ $destinatario->stato }}
                                </span>
                            @else
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-amber-400">
                                    {{ $destinatario->stato }}
                                </span>
                            @endif
                        </div>
                    </label>
                @empty
                    <div class="p-4 text-center text-sm text-slate-500">Nessun contatto registrato nel sistema</div>
                @endforelse
            </div>
            @error('destinatari')
                <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
            @enderror
        </div>
        {{-- Pulsanti di Azione --}}
        <div class="flex justify-end gap-3">
            <a href="{{ url()->previous() }}" class="px-4 py-2 rounded-lg text-sm font-medium border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                Annulla
            </a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                {{ isset($lista) ? 'Aggiorna Lista' : 'Salva Lista' }}
            </button>
        </div>
    </form>
</div>
@endsection