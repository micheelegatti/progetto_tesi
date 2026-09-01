@extends('app')

@section('breadcrumbs')
    <li>
        <a href="{{ route('campagna') }}" class="hover:text-[#722e89] dark:hover:text-purple-300 transition">Campagna</a>
    </li>
    <li>
        <span class="text-slate-300 dark:text-slate-600">/</span>
    </li>
    <li>
        <span class="font-semibold text-slate-800 dark:text-slate-200">Creazione</span>
    </li>
@endsection

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    
    {{-- Intestazione --}}
    <div>
        <h1 class="text-2xl font-bold text-stone-900">Crea Nuova Campagna</h1>
        <p class="text-sm text-stone-500">Assegna un nome alla campagna e seleziona il template strutturale di partenza.</p>
    </div>

    <form action="{{ url('dashboard/campagna/store') }}" method="POST" class="bg-white border border-stone-200 rounded-xl p-6 shadow-sm space-y-6">
        @csrf

        {{-- Nome Campagna --}}
        <div class="space-y-2">
            <label for="name" class="block text-xs font-semibold text-stone-600 uppercase tracking-wider">Nome Campagna</label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                required
                placeholder="Es. Newsletter Promozionale Primavera" 
                class="w-full border border-stone-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
            />
        </div>

        {{-- Selezione Template (L'utente sceglie qui quale ID inviare) --}}
        <div class="space-y-2">
            <label for="template_id" class="block text-xs font-semibold text-stone-600 uppercase tracking-wider">Seleziona Template</label>
            <select 
                name="template_id" 
                id="template_id" 
                required
                class="w-full border border-stone-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 bg-white"
            >
                <option value="" disabled selected>Scegli un modello strutturato...</option>
                @foreach($templates as $template)
                    {{-- L'ID del template selezionato viene inviato automaticamente nel POST --}}
                    <option value="{{ $template->id }}">{{ $template->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Bottoni di azione --}}
        <div class="flex justify-end gap-3 pt-4 border-t border-stone-100">
            <a 
                href="{{ url()->previous() }}" 
                class="px-4 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 text-sm font-semibold rounded-lg transition"
            >
                Annulla
            </a>
            <button 
                type="submit" 
                class="px-4 py-2 bg-[#722e89] hover:bg-[#5e2272] text-white text-sm font-semibold rounded-lg shadow-sm transition"
            >
                Salva e Procedi all'Editor
            </button>
        </div>
    </form>

</div>
@endsection