<script setup lang="ts">
import type { Block } from '@/types/block'

const props = defineProps<{
    selectedBlock: Block | null
}>()

// Definisco i blocchi di tipo layout (Griglia rimossa ufficialmente)
const layoutBlocks = [
    { type: 'container', label: 'Contenitore' },
    { type: 'header',    label: 'Header' },
    { type: 'footer',    label: 'Footer' },
    { type: 'section',   label: 'Section' },
] as const

// Definisco i blocchi di tipo contenuto
const contentBlocks = [
    { type: 'title',   label: 'Titolo' },
    { type: 'text',    label: 'Testo' },
    { type: 'image',   label: 'Immagine' },
    { type: 'button',  label: 'Pulsante' },
    { type: 'divider', label: 'Divisore' },
    { type: 'html',    label:'Codice HTML'}
] as const

</script>

<template>
    <aside class="w-52 border-r border-stone-200 bg-stone-50 flex flex-col flex-shrink-0 overflow-y-auto dark:border-stone-800 dark:bg-stone-950">
        <div class="px-4 py-3 border-b border-stone-200 dark:border-stone-800">
            <h2 class="text-xs font-semibold text-stone-500 uppercase tracking-wider dark:text-stone-400">Elementi</h2>
        </div>

        <!-- Sezione Layout -->
        <div class="p-3">
            <p class="text-xs text-stone-400 px-1 pb-2 font-semibold uppercase tracking-wider dark:text-stone-500">Layout</p>
            <div
                v-for="block in layoutBlocks"
                :key="block.type"
                :data-type="block.type"
                draggable="true"
                @dragstart="(e) => e.dataTransfer!.setData('block-type', block.type)"
                class="w-full flex items-center gap-2 px-3 py-2 rounded-lg border border-stone-200 bg-white hover:border-blue-400/70 hover:bg-blue-50/40 text-sm text-stone-700 mb-2 cursor-grab active:cursor-grabbing transition dark:border-stone-800 dark:bg-stone-900 dark:text-stone-200 dark:hover:border-blue-500 dark:hover:bg-blue-950/20"
            >
                {{ block.label }}
            </div>
        </div>

        <!-- Sezione Contenuto -->
        <div v-if="selectedBlock">
            <div class="p-3">
                <p class="text-xs text-stone-400 px-1 pb-2 font-semibold uppercase tracking-wider dark:text-stone-500">Contenuto</p>
                <div
                    v-for="block in contentBlocks"
                    :key="block.type"
                    :data-type="block.type"
                    draggable="true"
                    @dragstart="(e) => e.dataTransfer!.setData('block-type', block.type)"
                    class="w-full flex items-center gap-2 px-3 py-2 rounded-lg border border-stone-200 bg-white hover:border-blue-400/70 hover:bg-blue-50/40 text-sm text-stone-700 mb-2 cursor-grab active:cursor-grabbing transition dark:border-stone-800 dark:bg-stone-900 dark:text-stone-200 dark:hover:border-blue-500 dark:hover:bg-blue-950/20"
                >
                    {{ block.label }}
                </div>
            </div>
        </div>
        <div v-else class="px-1 py-2">
            <p class="text-[11px] text-stone-400 italic text-center ">
                    Clicca su un'area nel canvas per visualizzare i widget
            </p>
        </div>
    </aside>
</template>