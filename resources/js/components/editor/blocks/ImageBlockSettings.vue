<script setup lang="ts">
import type { Block } from '@/types/block'
import { ref } from 'vue'
import axios from 'axios'
import MediaLibrary from './MediaLibrary.vue'

const showMediaLibrary = ref(false)
const uploading = ref(false)

const props = defineProps<{ 
    blockSelected: Block 
}>()

// Funzione per caricare direttamente un'immagine sul server/R2
const uploadImage = async (event: Event) => {
    const target = event.target as HTMLInputElement
    if (!target.files || target.files.length === 0) return

    const file = target.files[0]
    const formData = new FormData()
    formData.append('image', file)

    uploading.value = true
    try {
        const response = await axios.post('/dashboard/immagini/store', formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        })
        
        // Assegna l'URL o il path restituito dal backend direttamente al blocco
        if (response.data.url) {
            props.blockSelected.props!.src = response.data.url
        } else if (response.data.path) {
            props.blockSelected.props!.src = response.data.path
        }
    } catch (error) {
        console.error('Errore durante il caricamento dell\'immagine:', error)
    } finally {
        uploading.value = false
        target.value = '' // Pulisce l'input file
    }
}
</script>

<template>
  <div class="flex flex-col gap-3 p-4">
    <div class="flex flex-col gap-3">

      <!-- CONTENUTO -->
      <div class="border-b border-gray-200 pb-3">
        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Contenuto</p>
        
        <label class="flex flex-col gap-1 mb-2">
          <span class="text-xs text-gray-500">Src</span>
          <input v-model="blockSelected.props!.src"
            class="border border-gray-200 rounded-lg p-2 text-sm resize-none focus:outline-none focus:border-[#722e89]" />
        </label>

        <label class="flex flex-col gap-1 mb-3">
          <span class="text-xs text-gray-500">Alt</span>
          <input v-model="blockSelected.props!.alt"
            class="border border-gray-200 rounded-lg p-2 text-sm resize-none focus:outline-none focus:border-[#722e89]" />
        </label>

        <!-- Sezione Azioni Immagine: Upload Diretto + Media Library -->
        <div class="flex flex-col gap-2">
          <!-- Caricamento diretto in memoria -->
          <label class="flex flex-col gap-1">
            <span class="text-xs text-gray-500">Carica nuova immagine</span>
            <input type="file" @change="uploadImage" :disabled="uploading"
                   class="block w-full text-sm text-slate-500 dark:text-slate-400
                          file:mr-4 file:py-2 file:px-3
                          file:rounded-lg file:border-0
                          file:text-xs file:font-semibold
                          file:bg-[#f3e8f7] file:text-[#722e89]
                          hover:file:bg-[#e7d1ef]
                          cursor-pointer" />
            <span v-if="uploading" class="text-xs text-[#722e89] animate-pulse">Caricamento in corso...</span>
          </label>

          <!-- Pulsante per aprire la libreria esistente -->
          <button type="button" @click="showMediaLibrary = true"
                  class="w-full mt-1 py-2 px-3 bg-[#722e89] hover:bg-[#5e2272] text-white text-sm font-medium rounded-lg transition shadow-sm">
            Scegli da libreria esistente
          </button>
        </div>

        <MediaLibrary 
            v-model:visible="showMediaLibrary"
            @select="(url:string) => props.blockSelected.props!.src = url"
        />
      </div>

      <!-- Ridimensionamento -->
      <div class="border-b border-gray-200 pb-3">
        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Ridimensionamento</p>
        <label class="flex flex-col gap-1">
            <span class="text-xs text-gray-500">Larghezza (%)</span>
            <input v-model.number="blockSelected.style!.width" type="number" min="0" max="100"
            class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-[#722e89]" />
        </label>
        <label class="flex flex-col gap-1">
            <span class="text-xs text-gray-500">Altezza (%)</span>
            <input v-model.number="blockSelected.style!.height" type="number" min="0" max="100"
            class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-[#722e89]" />
        </label>
        <label class="flex flex-col gap-1 mb-2">
          <span class="text-xs text-gray-500">Altezza Massima (px)</span>
          <input
            v-model.number="blockSelected.style!.maxHeight"
            type="number"
            min="0"
            step="1"
            placeholder="Es. 300"
            class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-[#722e89]"
          />
        </label>
        <label class="flex flex-col gap-1">
          <span class="text-xs text-gray-500">Object-fit</span>
          <select v-model="blockSelected.style!.objectFit"
            class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-[#722e89] bg-white">
            <option value='fill'>Riempi</option>
            <option value='cover'>Cover</option>
            <option value="contain">Contenitore</option>
            <option value="scale-down">Riduci</option>
          </select>
        </label>
        
        <div v-if="blockSelected.style?.objectFit === 'cover' || blockSelected.style?.objectFit === 'contain' || blockSelected.style?.objectFit === 'scale-down'">
          <label class="flex flex-col gap-1 mt-2">
            <span class="text-xs text-gray-500">Object-Position</span>
            <select v-model="blockSelected.style!.objectPosition"
              class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-[#722e89] bg-white">
                <option value='left top'>Sopra a sinistra</option>
                <option value='center top'>Sopra al centro</option>
                <option value="right top">Sopra a destra</option>
                <option value="left center">Centrato a Sinistra</option>
                <option value='center center '>Centrato</option>
                <option value="right center">Centrato a destra</option>
                <option value='left bottom'>In basso a sinistra</option>
                <option value="center bottom">In basso al centro</option>
                <option value="right bottom">In basso a destra</option>
            </select>
          </label>
        </div>

        <div class="grid grid-cols-2 gap-2 mt-2 mb-2">
              <label class="flex flex-col gap-1">
              <span class="text-xs text-gray-500">Opacity</span>
              <input
                  v-model.number="blockSelected.style!.opacity"
                  type="number"
                  min="0" max="1" step="0.05"
                  class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-[#722e89]"
              />
              </label>

              <label class="flex flex-col gap-1">
              <span class="text-xs text-gray-500">Display</span>
              <select v-model="blockSelected.layout!.display"
                class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-[#722e89] bg-white">
                  <option value='none'>None</option>
                  <option value='block'>Block</option>
              </select>
              </label>
          </div>
      </div>

      <!-- BORDO -->
      <div class="pb-3 border-b border-gray-200">
          <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Bordo</p>
          <div class="grid grid-cols-2 gap-2 mb-2">
              <label class="flex flex-col gap-1">
              <span class="text-xs text-gray-500">Spessore (px)</span>
              <input
                  v-model.number="blockSelected.style!.border!.width"
                  type="number"
                  min="0"
                  class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-[#722e89]"
              />
              </label>
              <label class="flex flex-col gap-1">
              <span class="text-xs text-gray-500">Radius (px)</span>
              <input
                  v-model.number="blockSelected.style!.border!.radius"
                  type="number"
                  min="0"
                  class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-[#722e89]"
              />
              </label>
          </div>
          <label class="flex flex-col gap-1 mb-2">
              <span class="text-xs text-gray-500">Stile</span>
              <select
              v-model="blockSelected.style!.border!.style"
              class="border border-gray-200 rounded-lg p-2 text-sm focus:outline-none focus:border-[#722e89] bg-white"
              >
              <option value="solid">Solid</option>
              <option value="dashed">Dashed</option>
              <option value="dotted">Dotted</option>
              <option value="double">Double</option>
              <option value="groove">Groove</option>
              <option value="none">None</option>
              </select>
          </label>
          <label class="flex flex-col gap-1">
              <span class="text-xs text-gray-500">Colore</span>
              <input
              v-model="blockSelected.style!.border!.color"
              type="color"
              class="w-full h-9 rounded-lg border border-gray-200 p-1 cursor-pointer"
              />
          </label>
      </div>

      <!-- BOX SHADOW -->
      <div class="pb-3 border-b border-gray-200">
        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Ombra</p>
        <div class="flex flex-col gap-2 mb-2">
            <div class="grid grid-cols-4 gap-1">
                <input v-model.number="blockSelected.style!.boxShadow!.offsetX" type="number" step="1" class="input border border-gray-200 rounded-lg py-1 px-2 text-sm focus:outline-none focus:border-[#722e89]" />
                <input v-model.number="blockSelected.style!.boxShadow!.offsetY" type="number" step="1" class="input border border-gray-200 rounded-lg py-1 px-2 text-sm focus:outline-none focus:border-[#722e89]" />
                <input v-model.number="blockSelected.style!.boxShadow!.blurRadius" type="number" step="1" class="input border border-gray-200 rounded-lg py-1 px-2 text-sm focus:outline-none focus:border-[#722e89]" />
                <input v-model.number="blockSelected.style!.boxShadow!.spreadRadius" type="number" step="1" class="input border border-gray-200 rounded-lg py-1 px-2 text-sm focus:outline-none focus:border-[#722e89]" />
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
                <input v-model.number="blockSelected.style!.padding!.top" type="number" step="0.1" class="input border border-gray-200 rounded-lg py-1 px-2 text-sm focus:outline-none focus:border-[#722e89]" />
                <input v-model.number="blockSelected.style!.padding!.bottom" type="number" step="0.1" class="input border border-gray-200 rounded-lg py-1 px-2 text-sm focus:outline-none focus:border-[#722e89]" />
                <input v-model.number="blockSelected.style!.padding!.right" type="number" step="0.1" class="input border border-gray-200 rounded-lg py-1 px-2 text-sm focus:outline-none focus:border-[#722e89]" />
                <input v-model.number="blockSelected.style!.padding!.left" type="number" step="0.1" class="input border border-gray-200 rounded-lg py-1 px-2 text-sm focus:outline-none focus:border-[#722e89]" />
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
                <input v-model.number="blockSelected.style!.margin!.top" type="number" step="0.1" class="input border border-gray-200 rounded-lg py-1 px-2 text-sm focus:outline-none focus:border-[#722e89]" />
                <input v-model.number="blockSelected.style!.margin!.bottom" type="number" step="0.1" class="input border border-gray-200 rounded-lg py-1 px-2 text-sm focus:outline-none focus:border-[#722e89]" />
                <input v-model.number="blockSelected.style!.margin!.right" type="number" step="0.1" class="input border border-gray-200 rounded-lg py-1 px-2 text-sm focus:outline-none focus:border-[#722e89]" />
                <input v-model.number="blockSelected.style!.margin!.left" type="number" step="0.1" class="input border border-gray-200 rounded-lg py-1 px-2 text-sm focus:outline-none focus:border-[#722e89]" />
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