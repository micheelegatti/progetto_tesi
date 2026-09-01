<script setup lang="ts">
import { ref, watch } from 'vue'
import axios from 'axios'

const props = defineProps<{ visible: boolean }>()
const emit = defineEmits<{
    (e: 'update:visible', value: boolean): void
    (e: 'select', url: string): void
}>()

const images = ref<Array<{ id: number, url: string }>>([])
const loading = ref(false)

// Quando la modale diventa visibile, carica le immagini dal server
watch(() => props.visible, async (newVal) => {
    if (newVal) {
        loading.value = true
        try {
            const response = await axios.get('dashboard/immagini')
            images.value = response.data
        } catch (error) {
            console.error('Errore nel recupero della libreria media:', error)
        } finally {
            loading.value = false
        }
    }
})

const selectImage = (url: string) => {
    emit('select', url)
    close()
}

const close = () => {
    emit('update:visible', false)
}
</script>

<template>
  <div v-if="visible" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 max-w-2xl w-full mx-4 shadow-xl border border-slate-200 dark:border-slate-800 flex flex-col max-h-[80vh]">
      
      <!-- Intestazione -->
      <div class="flex justify-between items-center mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Libreria Media (Cloudflare R2)</h3>
        <button @click="close" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 text-sm font-semibold p-1">✕</button>
      </div>
      
      <!-- Contenuto (Griglia immagini) -->
      <div class="overflow-y-auto flex-1 py-2">
        <div v-if="loading" class="text-center py-12 text-sm text-slate-400 animate-pulse">
          Caricamento immagini...
        </div>
        
        <div v-else-if="images.length === 0" class="text-center py-12 text-sm text-slate-400">
          Nessuna immagine presente nel bucket R2. Caricane una prima!
        </div>

        <div v-else class="grid grid-cols-3 gap-3">
          <div v-for="img in images" :key="img.id" @click="selectImage(img.url)"
               class="group relative aspect-square rounded-xl overflow-hidden border border-slate-200 dark:border-slate-800 cursor-pointer hover:border-[#722e89] transition">
            <img :src="img.url" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" />
            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-xs font-medium">
              Seleziona
            </div>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <div class="flex justify-end gap-2 mt-4 pt-3 border-t border-slate-100 dark:border-slate-800">
        <button @click="close" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl text-sm font-medium transition">
          Chiudi
        </button>
      </div>

    </div>
  </div>
</template>