@extends('destinatari')

@section('contenuto_destinatari')
<div class="mb-6">
    <h1 class="text-xl font-bold text-slate-900 dark:text-white">
        Gestione Liste per: {{ $contatto->nome }} {{ $contatto->cognome }}
    </h1>
    <p class="text-sm text-slate-500">Seleziona o deseleziona le liste a cui appartiene questo contatto.</p>
</div>

{{-- Componente Alpine.js per la gestione della ricerca e del form --}}
<div class="max-w-2xl bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6 shadow-sm"
     x-data="{ search: '' }">
    
    <form action="{{ url('dashboard/destinatari/contatti/' . $contatto->id . '/liste') }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Barra di ricerca rapida con Alpine.js --}}
        <div class="mb-4">
            <label for="search" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Cerca Lista</label>
            <input type="text" id="search" x-model="search" placeholder="Digita per filtrare le liste..." 
                class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-3 py-2 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        {{-- Elenco Liste con Checkbox --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Liste Disponibili</label>
            <div class="border border-slate-200 dark:border-slate-800 rounded-lg max-h-60 overflow-y-auto divide-y divide-slate-200 dark:divide-slate-800 bg-slate-50/50 dark:bg-slate-900">
                @forelse($liste as $item)
                    {{-- x-show filtra in tempo reale in base a quello che scrivi nell'input --}}
                    <label class="flex items-center justify-between px-4 py-3 hover:bg-slate-100 dark:hover:bg-slate-800/50 cursor-pointer transition"
                           x-show="search === '' || '{{ strtolower($item->nome) }}'.includes(search.toLowerCase())">
                        <div class="flex items-center">
                            <input type="checkbox" name="liste[]" value="{{ $item->id }}"
                                {{ in_array($item->id, old('liste', $listeSelezionate ?? [])) ? 'checked' : '' }}
                                class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                            <span class="ml-3 text-sm font-medium text-slate-900 dark:text-white">
                                {{ $item->nome }}
                            </span>
                        </div>
                        @if($item->descrizione)
                            <span class="text-xs text-slate-400 truncate max-w-xs">{{ $item->descrizione }}</span>
                        @endif
                    </label>
                @empty
                    <div class="p-4 text-center text-sm text-slate-500">Nessuna lista creata nel sistema.</div>
                @endforelse
            </div>
            @error('liste')
                <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        {{-- Pulsanti di Azione --}}
        <div class="flex justify-end gap-3">
            <a href="{{ url()->previous() }}" class="px-4 py-2 rounded-lg text-sm font-medium border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                Annulla
            </a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                Salva Modifiche
            </button>
        </div>
    </form>
</div>
@endsection