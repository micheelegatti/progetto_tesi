<script setup lang="ts">
import { ref, provide, computed } from 'vue'
import axios from 'axios'
import type { Block } from '@/types/block'
import { blockDefaults } from '@/types/blockDefault'
import Sidebar from '@/components/editor/SidebarEditor.vue'
import Canvas from '@/components/editor/CanvasEditor.vue'
import SettingsPanelEditor from '@/components/editor/SettingsPanelEditor.vue'

// Props opzionali nel caso di un template esistente da modificare
const props = defineProps<{
    initialTemplateName?: string
    initialBlocks?: Block[]
    templateId?: number | null
}>()

// Nome del template (passato in modifica o default)
const templateName = ref(props.initialTemplateName ?? 'Nuovo Template Email')
const isSaving = ref(false)

//Id per i miei blocchi fissi del template(Header, Content e Footer)
const HEADER_ID = 111111
const BODY_ID = 555555
const FOOTER_ID = 999999

//Creazione array blocchi reattiva inserendo i blocchi iniziali o quelli di default
const blocks = ref<Block[]>(
    props.initialBlocks && props.initialBlocks.length > 0 
        ? props.initialBlocks 
        : [
            {
                ...structuredClone(blockDefaults['header']),
                id: HEADER_ID,
                children: []
            },
            {
                ...structuredClone(blockDefaults['container']),
                id: BODY_ID,
                children: []
            },
            {
                ...structuredClone(blockDefaults['footer']),
                id: FOOTER_ID,
                children: []
            }
          ]
)

//Variabile reattiva per blocco selezionato
const selectedBlock = ref<Block | null>(null)
//lo rendo "visibile" a chiunque importi lo importi
provide('selectedId', computed(() => selectedBlock.value?.id ?? null))

//Mi salva l'ordine aggiornato dei blocchi nella radice e
// 1) Garantisce che Header stia a indice 0, Footer in fondo
// 2) elimina oggetti corrotti
function updateBlocks(newBlocks: Block[]) {
    // 1. Rimuove eventuali elementi spazzatura o senza ID
    const validBlocks = newBlocks.filter(b => b && typeof b === 'object' && b.id && b.type)

    const header = validBlocks.find(b => b.id === HEADER_ID)
    const footer = validBlocks.find(b => b.id === FOOTER_ID)
    const middleBlocks = validBlocks.filter(b => b.id !== HEADER_ID && b.id !== FOOTER_ID)

    const sanitized: Block[] = []
    if (header) sanitized.push(header)
    sanitized.push(...middleBlocks)
    if (footer) sanitized.push(footer)

    blocks.value = sanitized
}

//funzione per aggiungere un blocco al root
function addBlock(payload: { type: Block['type']; targetIndex?: number } | Block['type']) {
    const type = typeof payload === 'string' ? payload : payload.type
    const targetIndex = typeof payload === 'object' ? payload.targetIndex : undefined

    // Controlli di sicurezza sui tipi di blocco contenitore
    if (['header', 'footer', 'container'].includes(type)) {
        alert('Header, Footer e Container principale sono già presenti.')
        return
    }

    //Controllo di sicurezza sui widget
    if (['title', 'text', 'image', 'button', 'divider', 'html'].includes(type)) {
        alert('Inserisci prima una Section nel canvas, poi trascina questo widget al suo interno!')
        return
    }

    //Recupero l'indice del footer
    //Header lo so già (indice 0)
    const footerIndex = blocks.value.findIndex(b => b.id === FOOTER_ID)

    //Blocco l'aggiunta se la posizione non è valida 
    if (targetIndex === undefined || targetIndex < 1 || targetIndex > footerIndex) {
        return
    }

    //Creo nuovo blocco
    const standard = structuredClone(blockDefaults[type])
    const newBlock: Block = {
        ...standard,
        id: Date.now(),
        children: []
    }

    // Inserisco la sezione esattamente nella posizione valida
    blocks.value.splice(targetIndex, 0, newBlock)
    selectedBlock.value = newBlock
}

//Metodo per aggiungere un blocco all'interno di un contenitore (nell'array children)
function addChildBlock(targetBlock: Block, type: Block['type']) {
    //Controllo che l'inserimento non sia nel Content
    if (targetBlock.id === BODY_ID) return

    // Creazione blocco
    const standard = structuredClone(blockDefaults[type])
    const child: Block = {
        ...standard,
        id: Date.now(),
        children: ['container', 'section'].includes(type) ? [] : undefined
    }

    if (!targetBlock.children) {
        targetBlock.children = []
    }

    targetBlock.children.push(child)
    selectedBlock.value = child
}

//Mi salva l'ordine aggiornato dei blocchi all'interno dell'array children di un blocco
function updateChildren(parent: Block, children: Block[]) {
    if (parent.id === BODY_ID) return
    const validChildren = children.filter(b => b && typeof b === 'object' && b.id && b.type)
    parent.children = validChildren
}

function selectBlock(block: Block) {
    if (block.id === BODY_ID) return
    selectedBlock.value = block
}

function deleteBlock(id: number) {
    if ([HEADER_ID, BODY_ID, FOOTER_ID].includes(id)) return

    blocks.value = blocks.value.filter(b => b.id !== id)

    function removeDeep(items: Block[]) {
        for (const item of items) {
            if (item.children) {
                item.children = item.children.filter(c => c.id !== id)
                removeDeep(item.children)
            }
        }
    }

    removeDeep(blocks.value)

    if (selectedBlock.value?.id === id) {
        selectedBlock.value = null
    }
}

// Funzione di salvataggio via Axios verso Laravel
async function saveTemplate() {
    console.log('VALORE TEMPLATE ID:', props.templateId);
    isSaving.value = true
    try {
        //Se sono in modifica (ho un ID) faccio un PUT, altrimenti un POST 
        const url = props.templateId 
            ? '/dashboard/template/' + props.templateId 
            : '/dashboard/template'
        const method = props.templateId ? 'put' : 'post'

        const response = await axios({
            method: method,
            url: url,
            data: {
                name: templateName.value,
                blocks: blocks.value
            }
        })

        console.log('Template salvato con successo!', response.data)
        alert('Template salvato correttamente!')
    } catch (error) {
        console.error('Errore durante il salvataggio:', error)
        alert('Errore durante il salvataggio del template.')
    } finally {
        isSaving.value = false
    }
}

</script>

<template>

    <div class="h-full flex flex-col overflow-hidden">
        <!-- Header con Nome Template e bottone salva (si può aggiungere altro) -->
        <header class="h-16 bg-white border-b border-stone-200 flex items-center justify-between px-6 flex-shrink-0 dark:bg-stone-900 dark:border-stone-800">
            
            <!-- Campo input per il nome del template (supporta caricamento da db) -->
            <div class="flex items-center gap-3">
                <span class="text-xs font-semibold text-stone-400 uppercase tracking-wider">Template:</span>
                <input 
                    v-model="templateName" 
                    type="text" 
                    class="px-3 py-1.5 text-sm font-medium border border-stone-300 rounded-lg bg-stone-50 focus:bg-white focus:outline-none focus:border-blue-500 dark:bg-stone-800 dark:border-stone-700 dark:text-white w-64"
                    placeholder="Nome del template..."
                >
            </div>

            <!-- Pulsante di salvataggio -->
            <button 
                @click="saveTemplate" 
                :disabled="isSaving"
                class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition disabled:opacity-50 shadow-sm flex items-center gap-2"
            >
                <span>{{ isSaving ? 'Salvataggio...' : 'Salva Template' }}</span>
            </button>
        </header>

        <!-- Contenitore dei 3 componenti principali (Sidebar, Canvas, Settings) -->
        <div class="flex flex-1 overflow-hidden">
            <Sidebar/>
            <Canvas
                :blocks="blocks"
                @select="selectBlock"
                @delete="deleteBlock"
                @drop-block="addBlock"
                @update:blocks="updateBlocks"
                @drop-block-in-container="addChildBlock"
                @update-children="updateChildren"
            />
            <SettingsPanelEditor 
                :block="selectedBlock"
                :blocks="blocks"
            />
        </div>
    </div>
</template>