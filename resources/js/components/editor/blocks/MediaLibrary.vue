<script setup lang="ts">
defineProps<{
    visible: boolean
}>()

const emit = defineEmits<{
    (e: 'update:visible', value: boolean): void
    (e: 'select', url: string): void
}>()

const close = () => {
    emit('update:visible', false)
}
</script>

<template>
  <div v-if="visible" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 max-w-lg w-full mx-4 shadow-xl border border-slate-200 dark:border-slate-800">
      
      <!-- Intestazione modale -->
      <div class="flex justify-between items-center mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Libreria Media</h3>
        <button @click="close" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 text-sm font-semibold p-1">
          ✕
        </button>
      </div>
      
      <!-- Contenuto della libreria -->
      <div class="py-12 text-center text-slate-500 dark:text-slate-400 text-sm">
        <p>Qui compariranno le immagini salvate su Cloudflare R2.</p>
      </div>

      <!-- Pulsanti di chiusura -->
      <div class="flex justify-end gap-2 mt-4 pt-3 border-t border-slate-100 dark:border-slate-800">
        <button @click="close" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl text-sm font-medium transition">
          Chiudi
        </button>
      </div>

    </div>
  </div>
</template>