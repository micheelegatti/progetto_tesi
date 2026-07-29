<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
    destinatari: {
        type: Array,
        default: () => []
    },
    initialSelected: {
        type: Array,
        default: () => []
    }
});

const search = ref('');
const selectedIds = ref([...props.initialSelected].map(Number));

// Filtra i contatti in tempo reale
const filteredContacts = computed(() => {
    if (!search.value) return props.destinatari;
    const term = search.value.toLowerCase();
    return props.destinatari.filter(d => {
        const fullName = `${d.nome || ''} ${d.cognome || ''} ${d.email || ''}`.toLowerCase();
        return fullName.includes(term);
    });
});

// Aggiunge o rimuove l'ID dalla lista globale mantenuta in memoria
const toggleSelection = (id) => {
    const numericId = Number(id);
    const index = selectedIds.value.indexOf(numericId);
    if (index > -1) {
        selectedIds.value.splice(index, 1);
    } else {
        selectedIds.value.push(numericId);
    }
};
</script>

<template>
    <div>
        <!-- Inviano SEMPRE tutti gli ID selezionati (anche se filtrati o nascosti) -->
        <input 
            type="hidden" 
            name="destinatari[]" 
            v-for="id in selectedIds" 
            :key="id" 
            :value="id"
        >

        <!-- Input di ricerca reattivo -->
        <div class="mb-3">
            <input 
                type="text" 
                v-model="search" 
                placeholder="Filtra contatti per nome o email..." 
                class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-3 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
            >
        </div>

        <!-- Lista dei contatti -->
        <div class="border border-slate-200 dark:border-slate-800 rounded-lg max-h-60 overflow-y-auto divide-y divide-slate-200 dark:divide-slate-800 bg-slate-50/50 dark:bg-slate-900">
            <template v-if="filteredContacts.length > 0">
                <label 
                    v-for="destinatario in filteredContacts" 
                    :key="destinatario.id"
                    class="flex items-center justify-between px-4 py-3 hover:bg-slate-100 dark:hover:bg-slate-800/50 cursor-pointer transition"
                >
                    <div class="flex items-center">
                        <!-- Checkbox visivo (senza name, gestito interamente dallo stato Vue) -->
                        <input 
                            type="checkbox" 
                            :checked="selectedIds.includes(destinatario.id)"
                            @change="toggleSelection(destinatario.id)"
                            class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 h-4 w-4"
                        >
                        <div class="ml-3 text-sm text-slate-900 dark:text-white">
                            <span class="font-medium">{{ destinatario.nome }} {{ destinatario.cognome }}</span>
                            <span class="text-slate-400 text-xs ml-2">({{ destinatario.email }})</span>
                        </div>
                    </div>
                    <div>
                        <span v-if="destinatario.stato === 'Iscritto'" class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                            {{ destinatario.stato }}
                        </span>
                        <span v-else class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-amber-400">
                            {{ destinatario.stato }}
                        </span>
                    </div>
                </label>
            </template>
            <div v-else class="p-4 text-center text-sm text-slate-500">
                Nessun contatto trovato
            </div>
        </div>
    </div>
</template>