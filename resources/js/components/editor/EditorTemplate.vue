<script setup lang="ts">
import { ref } from 'vue'
import type { Block } from '@/types/block'
import { blockDefaults } from '@/types/blockDefault'
import Sidebar from '@/components/editor/SidebarEditor.vue'
import Canvas from '@/components/editor/CanvasEditor.vue'
import SettingsPanelEditor from '@/components/editor/SettingsPanelEditor.vue'

// Id dei miei blocchi fissi (header, containe r(non modificabile), footer)
const HEADER_ID = 111111
const BODY_ID = 555555
const FOOTER_ID = 999999

// Array reattivo che contiene lo stato dei blocchi inseriti nel canvas
const blocks = ref<Block[]>([
    {
        ...structuredClone(blockDefaults['header']),
        id: HEADER_ID,
        children: []
    },
    {
        ...structuredClone(blockDefaults['container']),
        id: BODY_ID,
        children: [] // Rimane protetto e vuoto nel template
    },
    {
        ...structuredClone(blockDefaults['footer']),
        id: FOOTER_ID,
        children: []
    }
])

const selectedBlock = ref<Block | null>(null)

// Inserisce un blocco a livello root (nel canvas principale)
function addBlock(type: Block['type']) {
    // Blocco l'inserimento nel root di header, footer e container 
    // Chiedere ad Antonello se va bene
    if (['header', 'footer', 'container'].includes(type)) {
        alert('Puoi avere solo l\'Header, il Footer e il Container centrale predefiniti. Scegli un altro blocco (es. Section).')
        return
    }

    //Blocco l'inserimento dei widget a livello di root
    if (['title', 'text', 'image', 'button', 'divider', 'html'].includes(type)) {
        alert('Non puoi inserire un widget al di fuori di un contenitore!')
        return
    }

    //creo il nuovo blocco e ci associo id e array per i blocchi figlio
    const standard = structuredClone(blockDefaults[type])
    const block: Block = {
        ...standard,
        id: Date.now(),
        children: ['section'].includes(type) ? [] : undefined
    }
    
    //Inserito temporaneamente prima del footer (penultima posizione)
    blocks.value.splice(blocks.value.length - 1, 0, block)
    selectedBlock.value = block
}

// Inserisce un blocco dentro un Container / Area
function addChildBlock(parent: Block, type: Block['type']) {
    // Da template non devo poter inserire dentro il blocco content (il container)
    if (parent.id === BODY_ID) return

    const standard = structuredClone(blockDefaults[type])
    const child: Block = {
        ...standard,
        id: Date.now(),
        children: ['container', 'header', 'section', 'footer'].includes(type) ? [] : undefined
    }
    parent.children = [...(parent.children ?? []), child]
    selectedBlock.value = child
}

function updateChildren(parent: Block, children: Block[]) {
    if (parent.id === BODY_ID) return
    parent.children = children
}

function selectBlock(block: Block) {
    // Impedisce di selezionare il blocco corpo centrale per modificarne le impostazioni nel template
    if (block.id === BODY_ID) return
    selectedBlock.value = block
}

function deleteBlock(id: number) {
    // Vado a bloccare la cancellazione dei miei 3 blocchi fissi
    if ([HEADER_ID, BODY_ID, FOOTER_ID].includes(id)) return

    blocks.value = blocks.value.filter(b => b.id !== id)
    blocks.value.forEach(b => {
        if (b.children) {
            b.children = b.children.filter(c => c.id !== id)
        }
    })
    if (selectedBlock.value?.id === id) selectedBlock.value = null
}

function onSaved(slug: string | null) {
    //articleSlug.value = slug
}
</script>

<template>
    <div class="flex h-screen overflow-hidden">
        <Sidebar
            :selectedBlock="selectedBlock"
        />
        <Canvas
            :blocks="blocks"
            :selected-id="selectedBlock?.id ?? null"
            @select="selectBlock"
            @delete="deleteBlock"
            @drop-block="addBlock"
            @update:blocks="blocks = $event"
            @drop-block-in-container="addChildBlock"
            @update-children="updateChildren"
        />
        <SettingsPanelEditor 
            :block="selectedBlock"
            :blocks="blocks"
            @saved="onSaved"
        />
    </div>
</template>