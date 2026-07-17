<script setup lang="ts">
import type { Block } from '@/types/block'
import axios from 'axios'
//import MediaLibrary from './MediaLibrary.vue'

const showMediaLibrary = ref(false)

const props = defineProps<{ blockSelected: Block }>()

async function uploadImage(e: Event) {
    const file = (e.target as HTMLInputElement).files?.[0]
    if (!file) return
    
    const formData = new FormData()
    formData.append('image', file)
    
    const { data } = await axios.post('/api/upload-image', formData)
    props.blockSelected.props!.src = data.url
}
</script>

<template>
  <div class="flex flex-col gap-3 p-4">
    <div class="flex flex-col gap-3">

      <!-- CONTENUTO -->
      <div class="border-b border-gray-200 pb-3">
        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Contenuto</p>
        <label class="flex flex-col gap-1">
          <span class="text-xs text-gray-500">Src</span>
          <input v-model="blockSelected.props!.src"
            class="border border-gray-200 rounded-lg p-2 text-sm resize-none focus:outline-none focus:border-blue-400" />
        </label>
        <label class="flex flex-col gap-1">
          <span class="text-xs text-gray-500">Alt</span>
          <input v-model="blockSelected.props!.alt"
            class="border border-gray-200 rounded-lg p-2 text-sm resize-none focus:outline-none focus:border-blue-400" />
        </label>
        <Button label="Scegli immagine" @click="showMediaLibrary = true" />
        <MediaLibrary 
            v-model:visible="showMediaLibrary"
            @select="(url) => props.blockSelected.props!.src = url"
        />
      </div>
      <!-- Ridimensionamento -->
      <div class="border-b border-gray-200 pb-3">
        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Ridimensionamento</p>
        <label class="flex flex-col gap-1">
            <span class="text-xs text-gray-500">Larghezza (%)</span>
            <input v-model.number="blockSelected.style!.width" type="number" min="0" max="100"
            class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-blue-400" />
        </label>
        <label class="flex flex-col gap-1">
            <span class="text-xs text-gray-500">Altezza (%)</span>
            <input v-model.number="blockSelected.style!.height" type="number" min="0" max="100"
            class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-blue-400" />
        </label>
        <label class="flex flex-col gap-1">
          <span class="text-xs text-gray-500">Object-fit</span>
          <select v-model="blockSelected.style!.objectFit"
            class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-blue-400 bg-white">
            <option value='fill'>Riempi</option>
            <option value='cover'>Cover</option>
            <option value="contain">Contenitore</option>
            <option value="scale-down">Riduci</option>
          </select>
        </label>
        <!-- ObjectPosition appare solo per alcuni valori di objectfit-->
         <div  v-if="blockSelected.style?.objectFit === 'cover' || blockSelected.style?.objectFit === 'contain' || blockSelected.style?.objectFit === 'scale-down'" >
          <label class="flex flex-col gap-1">
            <span class="text-xs text-gray-500">Object-Position</span>
            <select v-model="blockSelected.style!.objectPosition"
              class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-blue-400 bg-white">
                <option value='left top'>Sopra a sinistra</option>
                <option value='center top'>Sopra al centro</option>
                <option value="right top">Sopra a destra</option>
                <option value="left center">Centrato a Sinistra</option>
                <option value='center center '>Centrato</option>
                <option value="right center">Centrato a destra</option>
                <option value='left bottom'>In basso a sinistra</option>
                <option value="center top">In basso al centro</option>
                <option value="right center">In basso a destra</option>
            </select>
          </label>
        </div>
        <div class="grid grid-cols-2 gap-2 mb-2">
              <!-- Opacity -->
              <label class="flex flex-col gap-1">
              <span class="text-xs text-gray-500">Opacity</span>
              <input
                  v-model.number="blockSelected.style!.opacity"
                  type="number"
                  min="0" max="1" step="0.05"
                  class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-blue-400"
              />
              </label>

              <!-- display -->
              <label class="flex flex-col gap-1">
              <span class="text-xs text-gray-500">Display</span>
              <select v-model="blockSelected.layout!.display"
                class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-blue-400 bg-white">
                  <option value='none'>None</option>
                  <option value='block'>Block</option>
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
    </div>

    </div>
  </div>
</template>