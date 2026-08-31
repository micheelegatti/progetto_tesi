<script setup lang="ts">
import { ref, provide, computed, onMounted } from 'vue'
import axios from 'axios'
import type { Block } from '@/types/block'
import { blockDefaults } from '@/types/blockDefault'
import Sidebar from '@/components/editor/SidebarEditor.vue'
import Canvas from '@/components/editor/CanvasEditorCampagna.vue'
import SettingsPanelEditor from '@/components/editor/SettingsPanelEditor.vue'

/*
    Effettuo un primo storage prima di aprire il builder, in infoCampagna dove chiedo all'utente il nome della 
    campagna e il template da utilizzare, per cui inizializzo la campagna con tutte le informazioni, tra cui 
    anche il content con i blocchi
*/

interface Campagna {
    id: number
    name: string
    content: any
    stato: string
}

const props = defineProps<{
    campagna?: Campagna
}>()

// Nome e id della campagna
const campagnaID = props.campagna?.id
const campagnaName = ref(props.campagna?.name)
const isSaving = ref(false)
const isSendingTest = ref(false)

//Id per i miei blocchi fissi del template(Header, Content e Footer)
//Header e footer potrebbero non servire
const HEADER_ID = 111111
const BODY_ID = 555555
const FOOTER_ID = 999999

//Creazione array blocchi reattiva inserendo i blocchi iniziali del template o quelli della campagna pre-esistente
const blocks = ref<Block[]>(
    //Caso apertura campagna già esistente
    props.campagna?.content && props.campagna.content.length > 0
        ? props.campagna.content.map((b: Block) => {
            if (b.id === BODY_ID && !b.children) {
                b.children = []
            }
            return b
          })
        // Fallback in caso di errore di caricamento
        : []
)

//Caso di fallback, blocco lo creazione/modifica della campagna e torno alla home delle campagne
onMounted(() => {
    const hasCampaignContent = props.campagna?.content && props.campagna.content.length > 0

    //Se non abbiamo né l'uno né l'altro, c'è un errore nei dati
    if (!hasCampaignContent) {
        console.error('Errore di caricamento')
        //Torno alla home delle campagne
        window.location.href = '/dashboard/campagna'
    }
})

//Variabile reattiva per blocco selezionato
const selectedBlock = ref<Block | null>(null)
//lo rendo "visibile" a chiunque lo importi
provide('selectedId', computed(() => selectedBlock.value?.id ?? null))

// Metodo per aggiungere un blocco all'interno di un contenitore
function addChildBlock(targetBlock: Block, type: Block['type']) {
    // Controllo che il tipo non sia header o footer
    if (type === 'header' || type === 'footer') return

    // Controllo che il target sia dentro il Body
    const body = blocks.value.find(b => b.id === BODY_ID)
    const isValid = targetBlock.id === BODY_ID || checkChildren(body?.children)

    function checkChildren(items?: Block[]): boolean {
        return items?.some(item => item.id === targetBlock.id || checkChildren(item.children)) ?? false
    }

    if (!isValid) return

    // Creazione e inserimento
    const child: Block = {
        ...structuredClone(blockDefaults[type]),
        id: Date.now(),
        children: ['container', 'section'].includes(type) ? [] : undefined
    }

    if (!targetBlock.children) targetBlock.children = []
    targetBlock.children.push(child)
    selectedBlock.value = child
}

//Mi salva l'ordine aggiornato dei blocchi all'interno dell'array children di un blocco
function updateChildren(parent: Block, children: Block[]) {
    const validChildren = children.filter(b => b && typeof b === 'object' && b.id && b.type)
    parent.children = validChildren
}

function selectBlock(block: Block) {
    //blocco sicuramente header e footer
    if (block.id === 111111 || block.id === 999999) return
    selectedBlock.value = block
}

function deleteBlock(id: number) {
    if ([HEADER_ID, BODY_ID, FOOTER_ID].includes(id)) return

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
async function saveCampagna() {
    console.log('VALORE CAMPAGNA ID:' + props.campagna?.id);
    isSaving.value = true
    try {
        const url = '/dashboard/campagna/' + props.campagna?.id
        const method = 'put'
        const response = await axios({
            method: method,
            url: url,
            data: {
                name: campagnaName.value,
                blocks: blocks.value,
                //vedere come aggiornare lo stato
            }
        })

        console.log('Campagna salvata con successo!', response.data)
        alert('Campagna salvata correttamente!')
    } catch (error) {
        console.error('Errore durante il salvataggio:', error)
        alert('Errore durante il salvataggio della campagna')
    } finally {
        isSaving.value = false
    }
}

/*Funzione per l'invio rapido del test - produzione locale
async function inviaTestRapido() {
    if (!props.campagna?.id) return
    isSendingTest.value = true
    try {
        // Chiamata al metodo di invio test che hai nel controller
        const url = `/dashboard/campagna/${props.campagna.id}/invia-test`
        const response = await axios.get(url)
        
        console.log('Test inviato con successo!', response.data)
        alert('Email di test inviata con successo!')
    } catch (error) {
        console.error('Errore durante l invio del test:', error)
        alert("Errore durante l'invio dell'email di test.")
    } finally {
        isSendingTest.value = false
    }
}*/
</script>

<template>
    <div class="h-full flex flex-col overflow-hidden">
        <!-- Header con Nome Template e bottone salva (si può aggiungere altro) -->
        <header class="h-16 bg-white border-b border-stone-200 flex items-center justify-between px-6 flex-shrink-0 dark:bg-stone-900 dark:border-stone-800">
            
            <!-- Campo input per il nome del template (supporta caricamento da db) -->
            <div class="flex items-center gap-3">
                <span class="text-xs font-semibold text-stone-400 uppercase tracking-wider">Campagna:</span>
                <input 
                    v-model="campagnaName" 
                    type="text" 
                    class="px-3 py-1.5 text-sm font-medium border border-stone-300 rounded-lg bg-stone-50 focus:bg-white focus:outline-none focus:border-blue-500 dark:bg-stone-800 dark:border-stone-700 dark:text-white w-64"
                    placeholder="Nome del template..."
                >
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ url('dashboard/campagna/' .$campagna->id. '/riepilogo') }}" 
                    class="inline-block bg-stone-100 hover:bg-stone-200/80 text-stone-800 px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                    Invia
                </a>
                <!-- Pulsante di salvataggio -->
                <button 
                    @click="saveCampagna" 
                    :disabled="isSaving"
                    class="px-5 py-2 bg-[#722e89] hover:bg-[#5e2272] text-white text-sm font-medium rounded-lg transition disabled:opacity-50 shadow-sm flex items-center gap-2"
                >
                    <span>{{ isSaving ? 'Salvataggio...' : 'Salva Campagna' }}</span>
                </button>
            </div>
        </header>

        <!-- Contenitore dei 3 componenti principali (Sidebar, Canvas, Settings) -->
        <div class="flex flex-1 overflow-hidden">
            <Sidebar/>
            <Canvas
                :blocks="blocks"
                @select="selectBlock"
                @delete="deleteBlock"
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