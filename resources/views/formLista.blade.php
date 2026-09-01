@extends('destinatari') 

@section('breadcrumbs')
    <li>
        <a href="{{ route('destinatari') }}" class="hover:text-[#722e89] dark:hover:text-purple-300 transition">Destinatari</a>
    </li>
    <li>
        <span class="text-slate-300 dark:text-slate-600">/</span>
    </li>
    <li>
        <a href="{{ url('dashboard/destinatari/liste') }}" class="hover:text-[#722e89] dark:hover:text-purple-300 transition">Liste</a>
    </li>
    <li>
        <span class="text-slate-300 dark:text-slate-600">/</span>
    </li>
    <li>
        <span class="font-semibold text-slate-800 dark:text-slate-200">Gestione</span>
    </li>
@endsection

@section('contenuto_destinatari')
<div class="mb-4">
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

        {{-- Selezione Contatti tramite il componente Vue --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Seleziona Contatti</label>
            
            <selezione-contatti
                :destinatari='@json($destinatari)' 
                :initial-selected='@json(old("destinatari", $contattiSelezionati ?? []))'>
            </selezione-contatti>

            @error('destinatari')
                <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        {{-- Pulsanti di Azione --}}
        <div class="flex justify-end gap-3">
            <a href="{{ url()->previous() }}" class="px-4 py-2 rounded-lg text-sm font-medium border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                Annulla
            </a>
            <button type="submit" class="bg-[#722e89] hover:bg-[#5e2272] text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                {{ isset($lista) ? 'Aggiorna Lista' : 'Salva Lista' }}
            </button>
        </div>
    </form>
</div>
@endsection

@vite('resources/js/app.ts')