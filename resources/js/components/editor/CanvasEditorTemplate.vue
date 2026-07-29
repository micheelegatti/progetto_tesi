<script setup lang="ts">
import { computed } from 'vue'
import { VueDraggable } from 'vue-draggable-plus'
import type { Block } from '@/types/block'
import { inject, type Ref } from 'vue'
import TitleBlock     from '@/components/editor/blocks/TitleBlock.vue'
import TextBlock      from '@/components/editor/blocks/TextBlock.vue'
import ImageBlock     from '@/components/editor/blocks/ImageBlock.vue'
import ButtonBlock    from '@/components/editor/blocks/ButtonBlock.vue'
import DividerBlock   from '@/components/editor/blocks/DividerBlock.vue'
import ContainerBlock from '@/components/editor/blocks/ContainerBlock.vue'
import HTMLBlock      from '@/components/editor/blocks/HTMLBlock.vue'
import SectionBlock   from '@/components/editor/blocks/SectionBlock.vue'
import HeaderBlock    from '@/components/editor/blocks/HeaderBlock.vue'
import FooterBlock    from '@/components/editor/blocks/FooterBlock.vue'

const props = defineProps<{
    blocks: Block[]
}>()

//recupero l'id selezionato come inject dal padre che lo ha dichiarato provide
const selectedId = inject<Ref<number | null>>('selectedId')

const emit = defineEmits<{
    (e: 'select', block: Block): void
    (e: 'delete', id: number): void
    (e: 'drop-block', payload: { type: Block['type']; targetIndex?: number }): void
    (e: 'update:blocks', blocks: Block[]): void
    (e: 'update-children', parent: Block, children: Block[]): void
    (e: 'drop-block-in-container', parent: Block, type: Block['type']): void
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
    container: ContainerBlock,
    html:      HTMLBlock,
    section:   SectionBlock,
    header:    HeaderBlock,
    footer:    FooterBlock,
}

function onDragOver(e: DragEvent) {
    e.preventDefault()
    if (e.dataTransfer) {
        e.dataTransfer.dropEffect = 'copy'
    }
}

function onDrop(e: DragEvent, dropIndex?: number) {
    e.preventDefault()
    
    const target = e.target as HTMLElement
    const isInsideChildContainer = target.closest('[data-container]')
    if (isInsideChildContainer) return

    const type = (e.dataTransfer?.getData('block-type') || e.dataTransfer?.getData('text/plain')) as Block['type']
    
    if (type) {
        emit('drop-block', { type, targetIndex: dropIndex })
    }
}

</script>

<template>
    <main
        class="flex-1 bg-gray-100 overflow-y-auto p-8 h-full"
        @dragover="onDragOver"
        @drop="onDrop($event)"
    >
        <div
            v-if="localBlocks.length === 0"
            class="flex flex-col items-center justify-center h-64 gap-3 text-gray-400 border-2 border-dashed border-gray-300 rounded-xl max-w-5xl mx-auto pointer-events-none select-none"
        >
            <p class="text-sm font-medium">Trascina un elemento dalla sidebar per aggiungerlo</p>
        </div>

        <VueDraggable
            v-else
            v-model="localBlocks"
            @update:model-value="emit('update:blocks', $event)"
            class="flex flex-col gap-4 max-w-5xl mx-auto min-h-[500px]"
            group="root-blocks"
            :animation="150"
            filter=".no-drag"
        >
            <div
                v-for="(block, index) in localBlocks"
                :key="block.id"
                class="relative group border transition-all w-full select-none rounded-none"
                :class="[
                    // Classe no-drag sui tre blocchi fissi
                    [111111, 555555, 999999].includes(block.id) ? 'no-drag' : '',

                    block.id === 555555 
                        ? 'bg-stone-100/90 border-dashed border-stone-300 cursor-not-allowed' 
                        : 'bg-white cursor-pointer',
                    
                    selectedId === block.id && block.id !== 555555
                        ? 'border-blue-500 border-[1.5px] shadow-sm'
                        : (block.id !== 555555 ? 'border-gray-200 hover:border-blue-300' : '')
                ]"
                :style="{
                    width: block.style?.width ? block.style?.width + '%' : '100%',
                    minHeight: block.style?.minHeight ? block.style?.minHeight + 'vh' : '',
                    marginInline: block.style?.textAlign === 'center' ? 'auto' : 
                         (block.style?.textAlign === 'right' ? '0 0 0 auto' : '0')
                }"
                @click="block.id === 555555 ? null : emit('select', block)"
                @drop.stop="onDrop($event, index + 1)"
            >
                <!-- ETICHETTA TIPO BLOCCO -->
                <div 
                    v-if="block.id !== 555555"
                    class="absolute -top-3 left-3 px-2 py-0.5 rounded text-[10px] font-semibold uppercase tracking-wider z-20 pointer-events-none transition-opacity"
                    :class="selectedId === block.id 
                        ? 'bg-blue-500 text-white shadow-sm opacity-100' 
                        : 'bg-stone-800 text-white opacity-0 group-hover:opacity-100'"
                >
                    {{ block.type }}
                </div>

                <!-- TASTO ELIMINA -->
                <div 
                    v-if="selectedId === block.id && ![111111, 555555, 999999].includes(block.id)" 
                    class="absolute top-2 right-2 hidden group-hover:flex gap-1 z-10"
                >
                    <button
                        class="w-6 h-6 flex items-center justify-center rounded border border-gray-200 bg-white text-gray-400 hover:text-red-500 text-xs shadow-sm"
                        @click.stop="emit('delete', block.id)"
                    >✕</button>
                </div>

                <div class="p-4">
                    <div 
                        v-if="block.id === 555555"
                        class="py-8 px-4 flex flex-col items-center justify-center gap-1.5 text-center"
                    >
                        <span class="text-[10px] uppercase font-bold tracking-wider bg-stone-200 text-stone-600 px-2.5 py-0.5 rounded-full">
                            Blocco content
                        </span>
                        <p class="text-xs font-medium text-stone-500">
                            Editabile solo sulla campagna
                        </p>
                    </div>

                    <component 
                        v-else
                        :is="componentMap[block.type]" 
                        :block="block"
                        :selected-id="selectedId"
                        @drop-block="(targetBlock: Block, type: Block['type']) => emit('drop-block-in-container', targetBlock, type)"
                        @update:children="(children: Block[]) => emit('update-children', block, children)"
                        @select="(b: Block) => emit('select', b)"
                        @delete="(id: number) => emit('delete', id)"
                    />
                </div>
            </div>
        </VueDraggable>
    </main>
</template>