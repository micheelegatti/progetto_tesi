<!-- HTMLBlockSettings.vue -->
<script setup lang="ts">
import type { Block } from '@/types/block'

defineProps<{ blockSelected: Block }>()

// Mantiene l'indentazione con Tab all'interno della textarea
function handleTab(e: KeyboardEvent) {
    if (e.key === 'Tab') {
        e.preventDefault()
        const target = e.target as HTMLTextAreaElement
        const start = target.selectionStart
        const end = target.selectionEnd

        // Inserisce 2 spazi al posto di cambiare focus di pagina
        target.value = target.value.substring(0, start) + '  ' + target.value.substring(end)
        target.selectionStart = target.selectionEnd = start + 2
    }
}
</script>

<template>
    <div class="flex flex-col gap-4 p-4">
        <div class="flex flex-col gap-1.5">
            <label class="text-xs font-semibold text-stone-500 uppercase tracking-wider dark:text-stone-400">
                Codice HTML Personalizzato
            </label>
            
            <textarea
                v-model="blockSelected.props!.text"
                @keydown="handleTab"
                rows="10"
                placeholder="<div style='color: red;'>Scrivi il tuo codice qui...</div>"
                class="w-full p-3 font-mono text-xs bg-stone-900 text-stone-100 rounded-lg border border-stone-800 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-y shadow-inner"
                spellcheck="false"
            ></textarea>
            
            <p class="text-[11px] text-stone-400 italic">
                Incolla o scrivi il codice HTML. Puoi usare il tasto TAB per rientrare il testo.
            </p>
        </div>

        <!-- SPAZIATURA (Padding) -->
        <div class="border-t border-stone-200 dark:border-stone-800 pt-3">
            <p class="text-xs font-semibold text-stone-500 uppercase tracking-wider mb-2 dark:text-stone-400">
                Spaziatura
            </p>
            <span class="text-xs text-gray-500">Padding</span> 
            <div class="flex flex-col gap-2">
                <div class="grid grid-cols-4 gap-1">
                    <input v-model.number="blockSelected.style!.padding!.top" type="number" step="0.1" class="border border-stone-200 dark:border-stone-800 dark:bg-stone-900 rounded-lg py-1 px-2 text-sm focus:outline-none focus:border-blue-400" />
                    <input v-model.number="blockSelected.style!.padding!.bottom" type="number" step="0.1" class="border border-stone-200 dark:border-stone-800 dark:bg-stone-900 rounded-lg py-1 px-2 text-sm focus:outline-none focus:border-blue-400" />
                    <input v-model.number="blockSelected.style!.padding!.right" type="number" step="0.1" class="border border-stone-200 dark:border-stone-800 dark:bg-stone-900 rounded-lg py-1 px-2 text-sm focus:outline-none focus:border-blue-400" />
                    <input v-model.number="blockSelected.style!.padding!.left" type="number" step="0.1" class="border border-stone-200 dark:border-stone-800 dark:bg-stone-900 rounded-lg py-1 px-2 text-sm focus:outline-none focus:border-blue-400" />
                </div>

                <div class="grid grid-cols-4 gap-1 text-xs text-stone-400 text-center">
                    <span>Sopra</span>
                    <span>Sotto</span>
                    <span>Destra</span>
                    <span>Sinistra</span>
                </div>
                <div class="flex flex-col gap-2 mb-2">
            <span class="text-xs text-gray-500">Margin</span> 
            <div class="grid grid-cols-4 gap-1">
                <input v-model.number="blockSelected.style!.margin!.top" type="number" step="0.1" class="input border border-gray-200 rounded-lg py-1 px-2 text-sm focus:outline-none focus:border-blue-400" />
                <input v-model.number="blockSelected.style!.margin!.bottom" type="number" step="0.1" class="input border border-gray-200 rounded-lg py-1 px-2text-sm focus:outline-none focus:border-blue-400" />
                <input v-model.number="blockSelected.style!.margin!.right" type="number" step="0.1" class="input border border-gray-200 rounded-lg py-1 px-2 text-sm focus:outline-none focus:border-blue-400" />
                <input v-model.number="blockSelected.style!.margin!.left" type="number" step="0.1" class="input border border-gray-200 rounded-lg py-1 px-2 text-sm focus:outline-none focus:border-blue-400" />
            </div>

            <div class="grid grid-cols-4 gap-1 text-xs text-gray-400">
                <span>Sopra</span>
                <span>Sotto</span>
                <span>Destra</span>
                <span>Sinistra</span>
            </div>
        </div>
            </div>
        </div>
    </div>
</template>