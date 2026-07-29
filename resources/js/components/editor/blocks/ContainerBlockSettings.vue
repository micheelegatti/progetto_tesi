<script setup lang="ts">
import { ref } from 'vue'
import type { Block } from '@/types/block'

defineProps<{ blockSelected: Block }>()
type Direction = 'row' | 'column'
type Justify = 'flex-start'|'center'|'flex-end'|'space-between'|'space-around'|'space-evenly'
type Align = 'flex-start' | 'center' | 'flex-end' | 'stretch'
type Wrap = 'nowrap' | 'wrap'
type AlignContent = 'flex-start' | 'center' | 'flex-end' | 'space-between' | 'space-around' | 'stretch'

</script>

<template>
  <div class="flex flex-col gap-3 p-4">
    <!--borderWidth: block.style?.border?.width + 'px',
            borderStyle: block.style?.border?.style,
            borderColor: block.style?.border?.color,
            borderRadius: block.style?.border?.radius + 'rem',
            padding: typeof block.style?.padding === 'number' ? block.style.padding + 'rem' : undefined,
            minHeight: block.style?.minHeight + 'rem',
            display: block.layout?.display,
            flexDirection: block.layout?.flexDirection,
            alignItems: block.layout?.alignItems,
            justifyContent: block.layout?.justifyContent,-->
    <!-- LAYOUT -->
    <div class="pb-3 border-b border-gray-200">
      <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">
          Layout
      </p>
      <!--flex directions-->
      <label class="flex flex-col gap-1">
        <span class="text-xs text-gray-500">Flex Direction</span>

        <div class="flex gap-1">
          <button
            v-for="dir in ['row', 'column']"
            :key="dir"
            class="flex-1 py-1 text-xs rounded border transition-colors"
            :class="blockSelected.layout!.flexDirection === dir
              ? 'bg-blue-500 text-white border-blue-500'
              : 'bg-white text-gray-500 border-gray-200 hover:border-blue-300'"
            @click="blockSelected.layout && (blockSelected.layout.flexDirection = dir as Direction)"
          >
            {{ dir === 'row' ? 'Row ↔' : 'Column ↕' }}
          </button>
        </div>
      </label>  

      <!-- Justify Content -->
      <label class="flex flex-col gap-1 pt-2">
        <span class="text-xs text-gray-500">Justify Content</span>

        <div class="flex gap-1">
          <button
            v-for="val in ['flex-start', 'center', 'flex-end', 'space-between', 'space-around', 'space-evenly']"
            :key="val"
            class="flex-1 py-2 text-xs rounded border transition-colors"
            :class="blockSelected.layout!.justifyContent === val
              ? 'bg-blue-500 text-white border-blue-500'
              : 'bg-white text-gray-500 border-gray-200 hover:border-blue-300'"
            @click="blockSelected.layout && (blockSelected.layout.justifyContent = val as Justify)"
          >
            {{
              val === 'flex-start'    ? '⇤' : 
              val === 'center'        ? '↔' : 
              val === 'flex-end'      ? '⇥' : 
              val === 'space-between' ? '⇤⇥' : 
              val === 'space-around'  ? '⫶' :  '┋'
            }}
          </button>
        </div>
      </label> 
    
      <!-- Align Items -->
      <label class="flex flex-col gap-1 pt-2">
        <span class="text-xs text-gray-500">Align Items</span>

        <div class="flex gap-1">
          <button
            v-for="val in ['flex-start', 'center', 'flex-end', 'stretch']"
            :key="val"
            class="flex-1 py-1 text-xs rounded border transition-colors"
            :class="blockSelected.layout!.alignItems === val
              ? 'bg-blue-500 text-white border-blue-500'
              : 'bg-white text-gray-500 border-gray-200 hover:border-blue-300'"
            @click="blockSelected.layout && (blockSelected.layout.alignItems = val as Align)"
          >
            {{
              val === 'flex-start' ? '⬆' :
              val === 'center' ? '↕' :
              val === 'flex-end' ? '⬇' :
              '⤢'
            }}
          </button>
        </div>
      </label>

      <!-- wrap-->
      <label class="flex flex-col gap-1">
        <span class="text-xs text-gray-500">Wrap</span>

        <div class="flex gap-1">
          <button
            v-for="dir in ['nowrap', 'wrap']"
            :key="dir"
            class="flex-1 py-1 text-xs rounded border transition-colors"
            :class="blockSelected.layout!.flexWrap === dir
              ? 'bg-blue-500 text-white border-blue-500'
              : 'bg-white text-gray-500 border-gray-200 hover:border-blue-300'"
            @click="blockSelected.layout && (blockSelected.layout.flexWrap = dir as Wrap)"
          >
            {{ dir === 'nowrap' ? 'No wrap ⮕' : 'Wrap ⤶' }}
          </button>
        </div>
      </label>

      <!-- Align Content -->
      <label v-if="blockSelected.layout?.flexWrap === 'wrap'" 
            class="flex flex-col gap-1">
        <span class="text-xs text-gray-500">Justify Content</span>

        <div class="flex gap-1">
          <button
            v-for="val in ['flex-start', 'center', 'flex-end', 'space-between', 'space-around', 'space-evenly']"
            :key="val"
            class="flex-1 py-1 text-xs rounded border transition-colors"
            :class="blockSelected.layout!.alignContent === val
              ? 'bg-blue-500 text-white border-blue-500'
              : 'bg-white text-gray-500 border-gray-200 hover:border-blue-300'"
            @click="blockSelected.layout && (blockSelected.layout.alignContent = val as AlignContent)"
          >
            {{
                val === 'flex-start'    ? '⇤' : 
                val === 'center'        ? '↔' : 
                val === 'flex-end'      ? '⇥' : 
                val === 'space-between' ? '⇤⇥' : 
                val === 'space-around'  ? '⫶' :  '┋'
              }}
          </button>
        </div>
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


    <!-- BORDO -->
    <div class="pb-3 border-b border-gray-200">
        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">
            Bordo
        </p>

        <div class="grid grid-cols-2 gap-2 mb-2">

            <!-- Width -->
            <label class="flex flex-col gap-1">
            <span class="text-xs text-gray-500">Spessore (px)</span>
            <input
                v-model.number="blockSelected.style!.border!.width"
                type="number"
                min="0"
                class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-blue-400"
            />
            </label>

            <!-- Radius -->
            <label class="flex flex-col gap-1">
            <span class="text-xs text-gray-500">Radius (px)</span>
            <input
                v-model.number="blockSelected.style!.border!.radius"
                type="number"
                min="0"
                class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-blue-400"
            />
            </label>
        </div>

        <!-- Style -->
        <label class="flex flex-col gap-1 mb-2">
            <span class="text-xs text-gray-500">Stile</span>
            <select
            v-model="blockSelected.style!.border!.style"
            class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-blue-400 bg-white"
            >
            <option value="solid">Solid</option>
            <option value="dashed">Dashed</option>
            <option value="dotted">Dotted</option>
            <option value="double">Double</option>
            <option value="groove">Groove</option>
            <option value="none">None</option>
            </select>
        </label>

        <!-- Color -->
        <label class="flex flex-col gap-1">
            <span class="text-xs text-gray-500">Colore</span>
            <input
            v-model="blockSelected.style!.border!.color"
            type="color"
            class="w-full h-9 rounded-lg border border-gray-200 p-1 cursor-pointer"
            />
        </label>
    </div>

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
                <input v-model.number="blockSelected.style!.margin!.bottom" type="number" step="0.1" class="input border border-gray-200 rounded-lg py-1 px-2 text-sm focus:outline-none focus:border-blue-400" />
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