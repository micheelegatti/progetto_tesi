<script setup lang="ts">
import type { Block } from '@/types/block'

//definisco i blocchi di tipo layout
const layoutBlocks = [
    { type: 'container', label: 'Contenitore' },
    { type: 'header', label: 'Header' },
    { type: 'footer', label: 'Footer' },
    { type: 'section', label: 'Section' },
    { type: 'grid',      label: 'Griglia' },
] as const

//definisco i blocchi di tipo contenuto
const contentBlocks = [
    { type: 'title',   label: 'Titolo' },
    { type: 'text',    label: 'Testo' },
    { type: 'image',   label: 'Immagine' },
    { type: 'button',  label: 'Pulsante' },
    { type: 'divider', label: 'Divisore' },
] as const
</script>

<template>
    <aside class="w-52 border-r border-gray-200 bg-gray-50 flex flex-col flex-shrink-0 overflow-y-auto">
        <div class="px-4 py-3 border-b border-gray-200">
            <h2 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Elementi</h2>
        </div>

        <div class="p-3">
            <p class="text-xs text-gray-400 px-1 pb-2 font-medium">Layout</p>
            <div
                v-for="block in layoutBlocks"
                :key="block.type"
                :data-type="block.type"
                draggable="true"
                @dragstart="(e) => e.dataTransfer!.setData('block-type', block.type)"
                class="w-full flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-200 bg-white hover:border-blue-400 hover:bg-blue-50 text-sm text-gray-700 mb-2 transition-colors"
            >
                {{ block.label }}
            </div>
        </div>

        <div class="p-3">
            <p class="text-xs text-gray-400 px-1 pb-2 font-medium">Contenuto</p>
            <div
                v-for="block in contentBlocks"
                :key="block.type"
                :data-type="block.type"
                draggable="true"
                @dragstart="(e) => e.dataTransfer!.setData('block-type', block.type)"
                class="w-full flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-200 bg-white hover:border-blue-400 hover:bg-blue-50 text-sm text-gray-700 mb-2 transition-colors"
            >
                {{ block.label }}
            </div>
        </div>
    </aside>
</template>