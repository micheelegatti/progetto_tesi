<script setup lang="ts">
import { computed } from 'vue'
import { VueDraggable } from 'vue-draggable-plus'
import type { Block } from '@/types/block'
import TitleBlock     from '@/components/editor/blocks/TitleBlock.vue'
import TextBlock      from '@/components/editor/blocks/TextBlock.vue'
import ImageBlock     from '@/components/editor/blocks/ImageBlock.vue'
import ButtonBlock    from '@/components/editor/blocks/ButtonBlock.vue'
import DividerBlock   from '@/components/editor/blocks/DividerBlock.vue'
import HTMLBlock      from '@/components/editor/blocks/HTMLBlock.vue'
import ContainerBlock from '@/components/editor/blocks/ContainerBlock.vue'
import HeaderBlock    from '@/components/editor/blocks/HeaderBlock.vue'
import FooterBlock    from '@/components/editor/blocks/FooterBlock.vue'
import SectionBlock   from '@/components/editor/blocks/SectionBlock.vue'

const props = defineProps<{
    blocks: Block[]
    selectedId: number | null
}>()

const emit = defineEmits<{
    (e: 'select', block: Block): void
    (e: 'delete', id: number): void
    (e: 'drop-block', type: Block['type']): void
    (e: 'update:blocks', blocks: Block[]): void
    (e: 'drop-block-in-container', parent: Block, type: Block['type']): void
    (e: 'update-children', parent: Block, children: Block[]): void
}>()

const localBlocks = computed({
    get: () => props.blocks,
    set: (val) => emit('update:blocks', val)
})

const componentMap: Record<Block['type'], any> = {
    title:     TitleBlock,
    text:      TextBlock,
    image:     ImageBlock,
    button:    ButtonBlock,
    divider:   DividerBlock,
    html:      HTMLBlock,
    container: ContainerBlock,
    header:    HeaderBlock,
    footer:    FooterBlock,
    section:   SectionBlock,
}

// FIX CHECKMOVE: Gestisce sia il riordinamento interno che il drop dalla Sidebar
function checkMove(evt: any) {
    const draggedId = evt.draggedContext.element?.id
    const futureIndex = evt.draggedContext.futureIndex

    const headerIndex = localBlocks.value.findIndex(b => b.id === 111111)
    const footerIndex = localBlocks.value.findIndex(b => b.id === 999999)

    // L'header deve restare in prima posizione
    if (draggedId === 111111) return futureIndex === headerIndex

    // Il footer deve restare in ultima posizione
    if (draggedId === 999999) return futureIndex === footerIndex

    // Qualunque altro blocco (nuovo dalla sidebar o esistente)
    // deve atterrare strettamente tra header e footer
    return futureIndex > headerIndex && futureIndex <= footerIndex
}

</script>

<template>
    <main class="flex-1 bg-stone-100 overflow-y-auto p-8 flex justify-center items-start">
        
        <VueDraggable
            v-model="localBlocks"
            :move="checkMove"
            group="blocks"
            :animation="150"
            :fallback-on-body="true"
            :invert-swap="true"
            class="w-full max-w-[650px] bg-white border border-stone-200 shadow-md rounded-xl min-h-[650px] flex flex-col gap-5 p-5 relative"
        >
            <div
                v-for="block in localBlocks"
                :key="block.id"
                class="relative group transition-all w-full h-auto"
                :class="[
                    selectedId === block.id ? 'outline-2 outline-blue-500 z-10' : '',
                    block.id === 555555 ? 'cursor-not-allowed' : 'cursor-pointer'
                ]"
                @click="block.id === 555555 ? null : emit('select', block)"
            >
                <!-- Etichetta del tipo di blocco -->
                <div 
                    v-if="block.id !== 555555" 
                    class="absolute top-2 left-2 hidden group-hover:flex items-center bg-stone-800 text-white text-[10px] uppercase font-semibold tracking-wider px-1.5 py-0.5 rounded shadow-sm z-20 pointer-events-none"
                >
                    {{ block.type }}
                </div>

                <!-- Tasto elimina -->
                <div 
                    v-if="![111111, 555555, 999999].includes(block.id)" 
                    class="absolute top-2 right-2 hidden group-hover:flex gap-1 z-20"
                >
                    <button 
                        class="w-5 h-5 flex items-center justify-center rounded border border-stone-200 bg-white text-stone-400 hover:text-red-500 text-xs shadow-sm" 
                        @click.stop="emit('delete', block.id)"
                    >✕</button>
                </div>

                <!-- AREA CENTRALE BLOCCATA (Senza il div aggressivo con pointer-events-none) -->
                <div 
                    v-if="block.id === 555555"
                    class="w-full min-h-[160px] bg-stone-50 border border-dashed border-stone-300 flex flex-col items-center justify-center p-6 text-stone-400 font-medium text-xs tracking-wide rounded-lg select-none"
                >
                    <span class="uppercase font-bold text-[9px] bg-stone-200 text-stone-600 px-2 py-0.5 rounded-full mb-1">
                        Corpo Centrale protetto
                    </span>
                    Spazio riservato al contenuto dinamico dell'email.
                </div>

                <!-- RENDER COMPONENTI NATIVI -->
                <component 
                    v-else
                    :is="componentMap[block.type]" 
                    :block="block"
                    :selected-id="selectedId"
                    @drop-block="(type) => emit('drop-block-in-container', block, type)"
                    @update:children="(children) => emit('update-children', block, children)"
                    @select="(b) => emit('select', b)"
                    @delete="(id) => emit('delete', id)"
                />
            </div>
        </VueDraggable>

    </main>
</template>