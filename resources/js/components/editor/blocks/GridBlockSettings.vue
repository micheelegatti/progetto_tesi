<script setup lang="ts">
import type { Block } from '@/types/block'

const props = defineProps<{ blockSelected: Block }>()

const emit = defineEmits<{
  (e: 'update-grid', block: Block, newGrid: any[][]): void
}>()

function onGridStructureChange() {
  const block = props.blockSelected
  if (!block || block.type !== 'grid') return
  const cols = block.props?.cols ?? 1
  const rows = block.props?.rows ?? 1
  const currentGrid = block.grid ?? []

  let newGrid = currentGrid.map(riga => {
    if (riga.length < cols) return  [...riga, ...Array(cols - riga.length).fill(null)]
    return riga.slice(0, cols)
  })

  if (rows > newGrid.length) {
    newGrid = [...newGrid, ...Array(rows - newGrid.length).fill(null).map(() => Array(cols).fill(null))]
  } else {
    newGrid = newGrid.slice(0, rows)
  }

  emit('update-grid', props.blockSelected, newGrid)
}
</script>


<template>
  <div class="flex flex-col gap-3 p-4">
    <!-- Setting Tabella -->
    <div class="border-b border-gray-200 pb-3">
      <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Impostazioni Tabella</p>
      <!--COLONNE, RIGHE, GAP-->  
      <label class="flex flex-col gap-1">
        <span class="text-xs text-gray-500">Colonne</span>
        <input v-model.number="blockSelected.props!.cols" type="number" min="1" max="4"
          class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-blue-400"
          @input="onGridStructureChange" />
      </label>
      <label class="flex flex-col gap-1">
        <span class="text-xs text-gray-500">Righe</span>
        <input v-model.number="blockSelected.props!.rows" type="number" min="1" max="10"
          class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-blue-400"
          @input="onGridStructureChange" />
      </label>
    </div>

    <div class="pb-3 border-b border-gray-200">
        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">
            Sfondo
        </p>
        <label class="flex flex-col gap-1">
            <span class="text-xs text-gray-500">Colore Sfondo</span>
            <input
            v-model="blockSelected.style!.backgroundColor"
            type="color"
            class="w-full h-9 rounded-lg border border-gray-200 p-1 cursor-pointer"
            />
        </label>
    </div>

    <!-- SPAZIATURA-->
    <div class="border-b border-gray-200">
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
          <span class="text-xs text-gray-500">Gap (px)</span>
          <input v-model.number="blockSelected.layout!.gap" type="number" min="0" max="100"
          class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-blue-400" />
      </label>
      <label class="flex flex-col gap-1">
          <span class="text-xs text-gray-500">Larghezza (%)</span>
          <input v-model.number="blockSelected.style!.width" type="number" min="0" max="100"
          class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-blue-400" />
      </label>
      <label class="flex flex-col gap-1">
          <span class="text-xs text-gray-500">Altezza minima (%)</span>
          <input v-model.number="blockSelected.style!.minHeight" type="number" min="0" max="100"
          class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-blue-400" />
      </label>
    </div>
  </div>
</template>