@extends('destinatari') 

@section('contenuto_destinatari')
<div class="mb-6">
    <h1 class="text-xl font-bold text-slate-900 dark:text-white">
        {{ isset($destinatario) ? 'Modifica Contatto' : 'Aggiungi Singolo Destinatario' }}
    </h1>
    <p class="text-sm text-slate-500">
        {{ isset($destinatario) ? 'Modifica i dati del contatto selezionato.' : 'Compila i campi sottostanti per registrare un nuovo contatto.' }}
    </p>
</div>

<div class="max-w-2xl bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6 shadow-sm">
    {{-- L'action e il method cambiano in base alla presenza della variabile $destinatario --}}
    <form action="{{ isset($destinatario) ? url('dashboard/destinatari/import/' .$destinatario->id) : url('dashboard/destinatari/import/contatto') }}" method="POST">
        @csrf
        @if(isset($destinatario))
            @method('PUT')
        @endif

        {{-- Nome --}}
        <div class="mb-4">
            <label for="nome" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nome</label>
            <input type="text" name="nome" id="nome" value="{{ old('nome', $destinatario->nome ?? '') }}" required
                class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-3 py-2 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @error('nome')
                <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        {{-- Cognome --}}
        <div class="mb-4">
            <label for="cognome" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Cognome</label>
            <input type="text" name="cognome" id="cognome" value="{{ old('cognome', $destinatario->cognome ?? '') }}" required
                class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-3 py-2 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @error('cognome')
                <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        {{-- Email --}}
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $destinatario->email ?? '') }}" required
                class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-3 py-2 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @error('email')
                <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        {{-- Stato --}}
        <div class="mb-6">
            <label for="stato" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Stato</label>
            
            @php
                $currentStato = old('stato', isset($destinatario) ? ($destinatario->stato->value ?? $destinatario->stato) : '');
            @endphp

            <select name="stato" id="stato" required
                class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-3 py-2 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="Iscritto" {{ $currentStato == 'Iscritto' ? 'selected' : '' }}>Iscritto</option>
                <option value="Disiscritto" {{ $currentStato == 'Disiscritto' ? 'selected' : '' }}>Disiscritto</option>
            </select>
            
            @error('stato')
                <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        {{-- Pulsanti di azione --}}
        <div class="flex justify-end gap-3">
            <a href="{{ url()->previous() }}" class="px-4 py-2 rounded-lg text-sm font-medium border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                Annulla
            </a>
            <button type="submit" class="bg-[#722e89] hover:bg-[#5e2272] text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                {{ isset($destinatario) ? 'Aggiorna Contatto' : 'Salva Contatto' }}
            </button>
        </div>
    </form>
</div>
@endsection