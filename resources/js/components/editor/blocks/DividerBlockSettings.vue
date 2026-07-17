<script setup lang="ts">
import type { Block } from '@/types/block'

defineProps<{ blockSelected: Block }>()
</script>

<template>
  <div class="flex flex-col gap-3 p-4">

    <!-- CONTENUTO -->
    <div class="border-b border-gray-200 pb-3">
      <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Contenuto</p>
      <label class="flex flex-col gap-1">
        <span class="text-xs text-gray-500">Testo</span>
        <textarea v-model="blockSelected.props!.text" rows="1"
          class="border border-gray-200 rounded-lg p-2 text-sm resize-none focus:outline-none focus:border-blue-400" />
      </label>
      <!--Caratteristiche contenuto testo (le faccio apparire solo se c'è testo)-->
      <div v-if="blockSelected.props?.text && blockSelected.props.text !== ''">
        <label class="flex flex-col gap-1">
          <span class="text-xs text-gray-500">Allineamento</span>
          <div class="flex gap-1">
            <button v-for="align in ['left', 'center', 'right']" :key="align"
              class="flex-1 py-1 text-xs rounded border transition-colors"
              :class="blockSelected.style!.textAlign === align 
                ? 'bg-blue-500 text-white border-blue-500' 
                : 'bg-white text-gray-500 border-gray-200 hover:border-blue-300'"
              @click="blockSelected.style!.textAlign = align as any"
            >
              {{ align === 'left' ? '≡' : align === 'center' ? '≡' : '≡' }}
            </button>
          </div>
        </label>
        <label class="flex flex-col gap-1">
          <span class="text-xs text-gray-500">Font Family</span>
          <input v-model="blockSelected.style!.fontFamily" type="text" placeholder="es. Arial, sans-serif"
            class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-blue-400" />
        </label>
        <label class="flex flex-col gap-1">
          <span class="text-xs text-gray-500">Font Size (px)</span>
          <input v-model.number="blockSelected.style!.fontSize" type="number" min="8" max="120"
            class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-blue-400" />
        </label>
      </div>
    </div>

     <!-- STILE -->
    <div class="border-b border-gray-200 pb-3">
      <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">stile</p>
      <label class="flex flex-col gap-1">
        <span class="text-xs text-gray-500">Spessore (px)</span>
        <input v-model.number="blockSelected.style!.borderTopWidth" type="number" min="0" max="120"
          class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-blue-400" />
      </label>
      <label class="flex flex-col gap-1">
        <span class="text-xs text-gray-500">Style</span>
        <select v-model="blockSelected.style!.borderTopStyle"
          class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-blue-400 bg-white">
          <option value='solid'>Solido</option>
          <option value='dashed'>Tratteggiato</option>
          <option value="dotted">Punteggiato</option>
          <option value="double">Doppio</option>
          <option value="groove">Incavato</option>
          <option value="ridge">Rilievo</option> 
          <option value="inset">Incassato</option>
          <option value="outset">Sollevato</option>
        </select>
      </label>
      <label class="flex flex-col gap-1">
        <span class="text-xs text-gray-500">Colore</span>
        <input v-model="blockSelected.style!.borderTopColor" type="color"
          class="w-full h-9 rounded-lg border border-gray-200 p-1 cursor-pointer" />
      </label>
    </div>
<!-- SPAZIATURA -->
    <div class="pb-3">
      <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Spaziatura</p>
        
        <div class="flex flex-col gap-2 mb-2">
            <span class="text-xs text-gray-500">Padding</span> 
            <div class="grid grid-cols-4 gap-1">
                <input v-model.number="blockSelected.style!.padding!.top" type="number" step="0.1" class="input border border-gray-200 rounded-lg py-1 px-2 text-sm focus:outline-none focus:border-blue-400" />
                <input v-model.number="blockSelected.style!.padding!.bottom" type="number" step="0.1" class="input border border-gray-200 rounded-lg py-1 px-2 text-sm focus:outline-none focus:border-blue-400" />
                <input v-model.number="blockSelected.style!.padding!.right" type="number" step="0.1" class="input border border-gray-200 rounded-lg py-1 px-2 text-sm focus:outline-none focus:border-blue-400" />
                <input v-model.number="blockSelected.style!.padding!.left" type="number" step="0.1" class="input border border-gray-200 rounded-lg py-1 px-2 text-sm focus:outline-none focus:border-blue-400" />
            </div>

            <div class="grid grid-cols-4 gap-1 text-xs text-gray-400">
                <span>Sopra</span>
                <span>Sotto</span>
                <span>Destra</span>
                <span>Sinistra</span>
            </div>
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
        <label class="flex flex-col gap-1">
            <span class="text-xs text-gray-500">Larghezza (%)</span>
            <input v-model.number="blockSelected.style!.width" type="number" min="0" max="100"
            class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-blue-400" />
        </label>
    </div>
  </div>
</template>
