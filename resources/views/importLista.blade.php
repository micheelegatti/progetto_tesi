@extends('destinatari')

@section('contenuto_destinatari')
<div class="max-w-2xl bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6 shadow-sm">
    <div class="mb-6">
        <h1 class="text-xl font-bold text-slate-900 dark:text-white">Importa Contatti da CSV</h1>
        <p class="text-sm text-slate-500">Carica un file CSV con intestazione: <strong>Nome, Cognome, Email</strong></p>
    </div>

    <form action="{{ url('dashboard/destinatari/import/lista') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Selezione File CSV --}}
        <div class="mb-4">
            <label for="csv_file" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Seleziona File CSV</label>
            <input type="file" name="csv_file" id="csv_file" accept=".csv, text/csv" required
                class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-950 dark:file:text-indigo-300 cursor-pointer">
            @error('csv_file')
                <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        {{-- Associa a una lista esistente --}}
        <div class="mb-4">
            <label for="lista_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Associa a una Lista Esistente (Opzionale)</label>
            <select name="lista_id" id="lista_id" 
                class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-3 py-2 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">-- Nessuna associazione --</option>
                @foreach($liste as $l)
                    <option value="{{ $l->id }}">{{ $l->nome }}</option>
                @endforeach
            </select>
        </div>

        {{-- Oppure crea una nuova lista --}}
        <div class="mb-6">
            <label for="nuova_lista_nome" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Oppure crea una Nuova Lista</label>
            <input type="text" name="nuova_lista_nome" id="nuova_lista_nome" placeholder="Nome della nuova lista..."
                class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-3 py-2 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @error('nuova_lista_nome')
                <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        {{-- Pulsanti di Azione --}}
        <div class="flex justify-end gap-3">
            <a href="{{ url('dashboard/destinatari/contatti') }}" class="px-4 py-2 rounded-lg text-sm font-medium border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                Annulla
            </a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                Avvia Importazione
            </button>
        </div>
    </form>
</div>
@endsection