<script setup lang="ts">
import { computed } from 'vue'
import { VueDraggable } from 'vue-draggable-plus'
import type { Block } from '@/types/block'
import TitleBlock     from '@/components/editor/blocks/TitleBlock.vue'
import TextBlock      from '@/components/editor/blocks/TextBlock.vue'
import ImageBlock     from '@/components/editor/blocks/ImageBlock.vue'
import ButtonBlock    from '@/components/editor/blocks/ButtonBlock.vue'
import DividerBlock   from '@/components/editor/blocks/DividerBlock.vue'
import ContainerBlock from '@/components/editor/blocks/ContainerBlock.vue'
import GridBlock      from '@/components/editor/blocks/GridBlock.vue'
import HeaderBlock      from '@/components/editor/blocks/HeaderBlock.vue'
import FooterBlock      from '@/components/editor/blocks/FooterBlock.vue'
import SectionBlock      from '@/components/editor/blocks/SectionBlock.vue'

const props = defineProps<{
    blocks: Block[]
    selectedId: number | null
}>()

const emit = defineEmits<{
    (e: 'select', block: Block): void
    (e: 'delete', id: number): void
    (e: 'drop-block', type: Block['type']): void
    (e: 'update:blocks', blocks: Block[]): void
    (e: 'update-children', parent: Block, children: Block[]): void
    (e: 'drop-block-in-container', parent: Block, type: Block['type']): void
    (e: 'drop-block-in-grid', parent: Block, row: number, col: number, type: Block['type']): void  
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
    header:    HeaderBlock,
    footer:    FooterBlock,
    section:   SectionBlock,
    grid:      GridBlock,
}

function onDragOver(e: DragEvent) {
    e.preventDefault()
}

function onDrop(e: DragEvent) {
    e.preventDefault()
    if ((e.target as HTMLElement).closest('[data-container]')) return
    const type = e.dataTransfer?.getData('block-type') as Block['type']
    if (type) emit('drop-block', type)
}
</script>

<template>
    <main
        class="flex-1 bg-gray-100 overflow-y-auto p-8 flex justify-center"
        @dragover="onDragOver"
        @drop="onDrop"
    >
        <!-- Canvas vincolato a 600px per rispecchiare la larghezza standard delle email -->
        <div class="w-full max-w-[600px] h-full">
            <div
                v-if="localBlocks.length === 0"
                class="flex flex-col items-center justify-center h-full gap-3 text-gray-400 border-2 border-dashed border-gray-300 rounded-xl bg-white p-8"
            >
                <p class="text-sm">Trascina un elemento dalla sidebar per iniziare il template</p>
            </div>

            <VueDraggable
                v-else
                v-model="localBlocks"
                @update:model-value="emit('update:blocks', $event)"
                class="flex flex-col bg-white border border-gray-200 shadow-sm"
                group="blocks"
            >
                <div
                    v-for="block in localBlocks"
                    :key="block.id"
                    class="relative group cursor-pointer transition-all"
                    :class="selectedId === block.id
                        ? 'outline-2 outline-blue-500 outline -outline-offset-2 z-10'
                        : 'hover:outline-1 hover:outline-blue-300 hover:outline hover:-outline-offset-1'"
                    @click="emit('select', block)"
                >
                    <!-- Tasto elimina -->
                    <div class="absolute top-2 right-2 hidden group-hover:flex gap-1 z-20">
                        <button
                            class="w-6 h-6 flex items-center justify-center rounded border border-gray-200 bg-white text-gray-400 hover:text-red-500 text-xs"
                            @click.stop="emit('delete', block.id)"
                        >✕</button>
                    </div>

                    <!-- Render del componente -->
                    <div>
                        <component 
                            :is="componentMap[block.type]" 
                            :block="block"
                            :selected-id="selectedId"
                            @drop-block="(type: Block['type']) => emit('drop-block-in-container', block, type)"
                            @drop-block-grid="(gridBlock: Block, row: number, col: number, type: Block['type']) => emit('drop-block-in-grid', gridBlock, row, col, type)"
                            @update:children="(children: Block[]) => emit('update-children', block, children)"
                            @select="(b: Block) => emit('select', b)"
                            @delete="(id: number) => emit('delete', id)"
                        />
                    </div>
                </div>
            </VueDraggable>
        </div>
    </main>
</template>