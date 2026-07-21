<script setup lang="ts">
import type { Block } from '@/types/block'
import { ref } from 'vue'
import TitleBlockSettings     from '@/components/editor/blocks/TitleBlockSettings.vue'
import TextBlockSettings      from '@/components/editor/blocks/TextBlockSettings.vue' 
import ButtonBlockSettings    from '@/components/editor/blocks/ButtonBlockSettings.vue'
import ImageBlockSettings     from '@/components/editor/blocks/ImageBlockSettings.vue'
import DividerBlockSettings   from '@/components/editor/blocks/DividerBlockSettings.vue'
import ContainerBlockSettings from '@/components/editor/blocks/ContainerBlockSettings.vue'
import HeaderBlockSettings    from '@/components/editor/blocks/HeaderBlockSettings.vue'
import FooterBlockSettings    from '@/components/editor/blocks/FooterBlockSettings.vue'
import SectionBlockSettings   from '@/components/editor/blocks/SectionBlockSettings.vue'
import HTMLBlockSettings      from './blocks/HTMLBlockSettings.vue'

defineProps<{ 
  block: Block | null // Il blocco selezionato per mostrare i sotto-pannelli corretti
  blocks: Block[]     // L'albero completo dei blocchi
  isSaving?: boolean  // Stato di caricamento passato dal padre
}>()

const emit = defineEmits<{
  (e: 'save'): void // Notifica al componente padre che l'utente vuole salvare
}>()

const settingsMap: Record<Block['type'], any> = {
    title:     TitleBlockSettings,
    text:      TextBlockSettings,
    image:     ImageBlockSettings,
    button:    ButtonBlockSettings,
    divider:   DividerBlockSettings,
    html:      HTMLBlockSettings,
    container: ContainerBlockSettings,
    header:    HeaderBlockSettings,
    footer:    FooterBlockSettings,
    section:   SectionBlockSettings,
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
  <aside class="w-80 border-l border-stone-200 bg-stone-50 flex flex-col flex-shrink-0 overflow-hidden dark:border-stone-800 dark:bg-stone-950">
    
    <!-- Header -->
    <div class="px-4 py-3 border-b border-stone-200 dark:border-stone-800">
      <h2 class="text-xs font-semibold text-stone-500 uppercase tracking-wider dark:text-stone-400">Impostazioni Blocco</h2>
    </div>

    <!-- Contenuto scrollabile -->
    <div class="flex-1 overflow-y-auto">
      <div v-if="!block" class="flex items-center justify-center h-32 text-sm text-stone-400 p-4 text-center dark:text-stone-500">
        Seleziona un blocco nel canvas per modificarne le proprietà
      </div>

      <template v-else>
          <component  :is="settingsMap[block.type]" 
                      :block="block" 
                      :blockSelected="block"
          />
      </template>
    </div>

    <!-- Pulsante di salvataggio (sempre visibile in fondo alla barra) -->
    <div class="p-4 border-t border-stone-200 bg-white dark:border-stone-800 dark:bg-stone-900">
      <button 
        @click="emit('save')"
        :disabled="isSaving"
        class="w-full bg-blue-600 text-white py-2.5 text-sm font-semibold rounded-xl hover:bg-blue-700 disabled:opacity-60 transition shadow-sm"
      >
        {{ isSaving ? 'Salvataggio in corso...' : 'Salva Template' }}
      </button>
    </div>
  </aside>
</template>