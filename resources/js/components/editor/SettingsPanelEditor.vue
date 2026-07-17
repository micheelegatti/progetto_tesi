<script setup lang="ts">
import type { Block } from '@/types/block'
import { ref } from 'vue'
import TitleBlockSettings     from '@/components/editor/blocks/TitleBlockSettings.vue'
import TextBlockSettings      from '@/components/editor/blocks/TextBlockSettings.vue' 
import ButtonBlockSettings    from '@/components/editor/blocks/ButtonBlockSettings.vue'
import ImageBlockSettings     from '@/components/editor/blocks/ImageBlockSettings.vue'
import DividerBlockSettings   from '@/components/editor/blocks/DividerBlockSettings.vue'
import ContainerBlockSettings from '@/components/editor/blocks/ContainerBlockSettings.vue'
import GridBlockSettings      from '@/components/editor/blocks/GridBlockSettings.vue'

defineProps<{ 
  block: Block | null // Il blocco selezionato per mostrare i sotto-pannelli corretti
  blocks: Block[]     // L'albero completo dei blocchi
}>()

const emit = defineEmits<{
  (e: 'update-grid', block: Block, newGrid: (Block | null)[][]): void
  (e: 'save'): void // Notifica al componente padre che l'utente vuole salvare
}>()

const settingsMap: Record<Block['type'], any> = {
    title:     TitleBlockSettings,
    text:      TextBlockSettings,
    image:     ImageBlockSettings,
    button:    ButtonBlockSettings,
    divider:   DividerBlockSettings,
    container: ContainerBlockSettings,
    grid:      GridBlockSettings,
}

// ── Sezioni collassabili ──
const openSections = ref<Record<string, boolean>>({
  contenuto: true,
  stile: false,
  layout: false,
})

function toggleSection(key: string) {
  openSections.value[key] = !openSections.value[key]
}
</script>

<template>
  <aside class="w-80 border-l border-gray-200 bg-gray-50 flex flex-col flex-shrink-0 overflow-hidden">
    
    <!-- Header -->
    <div class="px-4 py-3 border-b border-gray-200">
      <h2 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Impostazioni Blocco</h2>
    </div>

    <!-- Contenuto scrollabile (mostra le impostazioni solo se selectedBlock/block non è null) -->
    <div class="flex-1 overflow-y-auto">
      <div v-if="!block" class="flex items-center justify-center h-32 text-sm text-gray-400 p-4 text-center">
        Seleziona un blocco nel canvas per modificarne le proprietà
      </div>

      <template v-else>
          <component  :is="settingsMap[block.type]" 
                      :block="block" 
                      :blockSelected="block"
                      @update-grid="(block: Block, newGrid: any[][]) => emit('update-grid', block, newGrid)"
          />
      </template>
    </div>

    <!-- Pulsante di salvataggio (sempre visibile in fondo alla barra) -->
    <div class="p-4 border-t border-gray-200 bg-white">
      <button @click="emit('save')"
        class="w-full bg-blue-500 text-white py-2 text-sm font-medium rounded-xl hover:bg-blue-600 transition-colors">
        Salva Template
      </button>
    </div>
  </aside>
</template>