@extends('app')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-xl shadow-sm overflow-hidden">
        
        <!-- Header della pagina -->
        <div class="px-6 py-5 border-b border-stone-200 dark:border-stone-800 flex items-center justify-between">
            <div>
                <h1 class="text-lg font-bold text-stone-900 dark:text-white">Riepilogo Invio</h1>
                <span class="text-sm font-medium text-stone-800 dark:text-stone-200">
                    Invio ordinario per campagna: <strong>{{ $campagna->name }} (Id: {{ $campagna->id }})</strong>
                </span>
            </div>
        </div>

        <!-- Form di configurazione invio -->
        <form action="{{ url('dashboard/campagna/invio') }}" method="POST" class="p-6 space-y-5">
            @csrf
            
            <!-- Campo nascosto per l'ID della campagna -->
            <input type="hidden" name="campagna_id" value="{{ $campagna->id }}">

            <!-- Oggetto Mail -->
            <div>
                <label for="oggetto" class="block text-xs font-semibold text-stone-600 dark:text-stone-300 uppercase tracking-wider mb-2">
                    Oggetto Mail <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="oggetto" 
                    name="oggetto" 
                    value="{{ old('oggetto', $invioCampagna->oggetto ?? '') }}"
                    required
                    class="w-full px-3 py-2 text-sm border border-stone-300 dark:border-stone-700 rounded-lg bg-stone-50 dark:bg-stone-800 text-stone-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Es. Scopri le novità..."
                >
            </div>

            <!-- Sommario Anteprima (max 100 caratteri) -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <label for="sommario" class="block text-xs font-semibold text-stone-600 dark:text-stone-300 uppercase tracking-wider">
                        Sommario Anteprima
                    </label>
                    <span class="text-[10px] text-stone-400">Max 100 caratteri</span>
                </div>
                <input 
                    type="text" 
                    id="sommario" 
                    name="sommario" 
                    maxlength="100"
                    value="{{ old('sommario', $invioCampagna->sommario ?? '') }}"
                    required
                    class="w-full px-3 py-2 text-sm border border-stone-300 dark:border-stone-700 rounded-lg bg-stone-50 dark:bg-stone-800 text-stone-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Testo breve visibile dopo l'oggetto..."
                >
            </div>

            <!-- Note -->
            <div>
                <label for="note" class="block text-xs font-semibold text-stone-600 dark:text-stone-300 uppercase tracking-wider mb-2">
                    Note
                </label>
                <textarea 
                    id="note" 
                    name="note" 
                    rows="2"
                    class="w-full px-3 py-2 text-sm border border-stone-300 dark:border-stone-700 rounded-lg bg-stone-50 dark:bg-stone-800 text-stone-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Note interne sulla campagna..."
                >{{ old('note', $invioCampagna->note ?? '') }}</textarea>
            </div>

            <!-- Tag -->
            <div>
                <label for="tag" class="block text-xs font-semibold text-stone-600 dark:text-stone-300 uppercase tracking-wider mb-2">
                    Tag
                </label>
                <input 
                    type="text" 
                    id="tag" 
                    name="tag" 
                    value="{{ old('tag', $invioCampagna->tag ?? '') }}"
                    class="w-full px-3 py-2 text-sm border border-stone-300 dark:border-stone-700 rounded-lg bg-stone-50 dark:bg-stone-800 text-stone-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="promo, estate, newsletter (separati da virgola)"
                >
            </div>

            <!-- Email Mittente -->
            <div>
                <label for="email_mittente" class="block text-xs font-semibold text-stone-600 dark:text-stone-300 uppercase tracking-wider mb-2">
                    Email Mittente <span class="text-red-500">*</span>
                </label>
                <input 
                    type="email" 
                    id="email_mittente" 
                    name="email_mittente" 
                    value="{{ old('email_mittente', $invioCampagna->email_mittente ?? 'noreply@tesimichele.softweb.srl') }}"
                    required
                    class="w-full px-3 py-2 text-sm border border-stone-300 dark:border-stone-700 rounded-lg bg-stone-50 dark:bg-stone-800 text-stone-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
            </div>

            <!-- Email di risposta -->
            <div>
                <label for="email_risposta" class="block text-xs font-semibold text-stone-600 dark:text-stone-300 uppercase tracking-wider mb-2">
                    Email di risposta
                </label>
                <input 
                    type="email" 
                    id="email_risposta" 
                    name="email_risposta" 
                    value="{{ old('email_risposta', $invioCampagna->email_risposta ?? '') }}"
                    class="w-full px-3 py-2 text-sm border border-stone-300 dark:border-stone-700 rounded-lg bg-stone-50 dark:bg-stone-800 text-stone-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="supporto@miodominio.it"
                >
            </div>

            <!-- Aggiunta destinatari  -->
            <div>
                <label class="block text-xs font-semibold text-stone-600 dark:text-stone-300 uppercase tracking-wider mb-2">
                    Aggiunta destinatari <span class="text-red-500">*</span>
                </label>
                <div class="space-y-2 p-3 border border-stone-300 dark:border-stone-700 rounded-lg bg-stone-50 dark:bg-stone-800 max-h-48 overflow-y-auto">
                    @php
                        $selectedLists = old('liste_id', isset($invioCampagna) && method_exists($invioCampagna, 'listes') ? $invioCampagna->listes->pluck('id')->toArray() : []);
                    @endphp
                    @foreach($liste as $lista)
                        <label class="flex items-center gap-2 text-sm text-stone-700 dark:text-stone-300 cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="liste_id[]" 
                                value="{{ $lista->id }}"
                                {{ in_array($lista->id, $selectedLists) ? 'checked' : '' }}
                                class="rounded border-stone-300 text-blue-600 focus:ring-blue-500"
                            >
                            <span>{{ $lista->nome }}</span>
                            <span class="text-xs text-stone-400">({{ $lista->destinatari()->count() }} iscritti)</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Pulsanti di azione -->
            <div class="pt-4 border-t border-stone-200 dark:border-stone-800 flex items-center justify-end gap-3">
                <a href="{{ url()->previous() }}" class="px-4 py-2 text-sm font-medium text-stone-700 dark:text-stone-300 hover:bg-stone-100 dark:hover:bg-stone-800 rounded-lg transition">
                    Annulla
                </a>
                <button type="submit" class="px-5 py-2 bg-[#722e89] hover:bg-[#5e2272] text-white text-sm font-medium rounded-lg transition shadow-sm">
                    Conferma e Procedi all'Invio
                </button>
            </div>
        </form>
    </div>
</div>
@endsection