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
        <textarea v-model="blockSelected.props!.text" rows="4"
          class="border border-gray-200 rounded-lg p-2 text-sm resize-none focus:outline-none focus:border-blue-400" />
      </label>
      <label class="flex flex-col gap-1">
        <span class="text-xs text-gray-500">href</span>
        <input v-model="blockSelected.props!.href" 
          class="border border-gray-200 rounded-lg p-2 text-sm resize-none focus:outline-none focus:border-blue-400" />
      </label>
    </div>

    <!-- TIPOGRAFIA -->
    <div class="border-b border-gray-200 pb-3">
      <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Tipografia</p>

      <div class="flex flex-col gap-2">
        <label class="flex flex-col gap-1">
          <span class="text-xs text-gray-500">Font Family</span>
          <input v-model="blockSelected.style!.fontFamily" type="text" placeholder="es. Arial, sans-serif"
            class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-blue-400" />
        </label>

        <div class="grid grid-cols-2 gap-2">
          <label class="flex flex-col gap-1">
            <span class="text-xs text-gray-500">Font Size (px)</span>
            <input v-model.number="blockSelected.style!.fontSize" type="number" min="8" max="120"
              class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-blue-400" />
          </label>
          <label class="flex flex-col gap-1">
            <span class="text-xs text-gray-500">Font Weight</span>
            <select v-model="blockSelected.style!.fontWeight"
              class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-blue-400 bg-white">
              <option value="300">Light</option>
              <option value="400">Regular</option>
              <option value="500">Medium</option>
              <option value="600">SemiBold</option>
              <option value="700">Bold</option>
              <option value="800">ExtraBold</option>
            </select>
          </label>
        </div>

        <!-- Corsivo e Sottolineato -->
        <div class="flex gap-2">
          <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox"
              :checked="blockSelected.style!.fontStyle === 'italic'"
              @change="blockSelected.style!.fontStyle = ($event.target as HTMLInputElement).checked ? 'italic' : 'normal'"
            />
            <span class="text-xs text-gray-500 italic">Corsivo</span>
          </label>
          <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox"
              :checked="blockSelected.style!.textDecoration === 'underline'"
              @change="blockSelected.style!.textDecoration = ($event.target as HTMLInputElement).checked ? 'underline' : 'none'"
            />
            <span class="text-xs text-gray-500 underline">Sottolineato</span>
          </label>
        </div>

        <label class="flex flex-col gap-1">
          <span class="text-xs text-gray-500">Allineamento</span>
          <div class="flex gap-1">
            <button v-for="align in ['left', 'center', 'right', 'justify']" :key="align"
              class="flex-1 py-1 text-xs rounded border transition-colors"
              :class="blockSelected.style!.textAlign === align 
                ? 'bg-blue-500 text-white border-blue-500' 
                : 'bg-white text-gray-500 border-gray-200 hover:border-blue-300'"
              @click="blockSelected.style!.textAlign = align as any"
            >
              {{ align === 'left' ? '≡' : align === 'center' ? '≡' : align === 'right' ? '≡' : '≡' }}
            </button>
          </div>
        </label>

        <div class="grid grid-cols-2 gap-2">
          <label class="flex flex-col gap-1">
            <span class="text-xs text-gray-500">Line Height</span>
            <input v-model.number="blockSelected.style!.lineHeight" type="number" min="1" max="3" step="0.1"
              class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-blue-400" />
          </label>
          <label class="flex flex-col gap-1">
            <span class="text-xs text-gray-500">Letter Spacing (px)</span>
            <input v-model.number="blockSelected.style!.letterSpacing" type="number" min="-5" max="20" step="0.1"
              class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-blue-400" />
          </label>
        </div>

        <label class="flex flex-col gap-1">
          <span class="text-xs text-gray-500">Word Spacing (px)</span>
          <input v-model.number="blockSelected.style!.wordSpacing" type="number" min="-5" max="20" step="0.1"
            class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-blue-400" />
        </label>

        <label class="flex flex-col gap-1">
          <span class="text-xs text-gray-500">Colore</span>
          <input v-model="blockSelected.style!.color" type="color"
            class="w-full h-9 rounded-lg border border-gray-200 p-1 cursor-pointer" />
        </label>
        
        <label class="flex flex-col gap-1">
          <span class="text-xs text-gray-500">Colore Sfondo</span>
          <input v-model="blockSelected.style!.backgroundColor" type="color"
            class="w-full h-9 rounded-lg border border-gray-200 p-1 cursor-pointer" />
        </label>

        <label class="flex flex-col gap-1">
          <span class="text-xs text-gray-500">Word Break</span>
          <select v-model="blockSelected.style!.wordBreak"
            class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-blue-400 bg-white">
            <option value="normal">Normal</option>
            <option value="break-word">Break Word</option>
          </select>
        </label>
      </div>
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

    <!-- BOX SHADOW-->
    <div class="pb-3">
      <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">ombra</p>
        
      <div class="flex flex-col gap-2 mb-2">
          <div class="grid grid-cols-4 gap-1">
              <input v-model.number="blockSelected.style!.boxShadow!.offsetX" type="number" step="1" class="input border border-gray-200 rounded-lg py-1 px-2 text-sm focus:outline-none focus:border-blue-400" />
              <input v-model.number="blockSelected.style!.boxShadow!.offsetY" type="number" step="1" class="input border border-gray-200 rounded-lg py-1 px-2 text-sm focus:outline-none focus:border-blue-400" />
              <input v-model.number="blockSelected.style!.boxShadow!.blurRadius" type="number" step="1" class="input border border-gray-200 rounded-lg py-1 px-2 text-sm focus:outline-none focus:border-blue-400" />
              <input v-model.number="blockSelected.style!.boxShadow!.spreadRadius" type="number" step="1" class="input border border-gray-200 rounded-lg py-1 px-2 text-sm focus:outline-none focus:border-blue-400" />
          </div>

          <div class="grid grid-cols-4 gap-1 text-xs text-gray-400">
              <span>Orizzontale</span>
              <span>Verticale</span>
              <span>Sfoca</span>
              <span>Diffondi</span>
          </div>
      </div>
      <label class="flex flex-col gap-1">
        <span class="text-xs text-gray-500">Colore</span>
        <input v-model="blockSelected.style!.boxShadow!.color" type="color"
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
        <label class="flex flex-col gap-1">
            <span class="text-xs text-gray-500">Altezza (px)</span>
            <input v-model.number="blockSelected.style!.height" type="number" min="0"
            class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-blue-400" />
        </label>
    </div>
  </div>
</template>