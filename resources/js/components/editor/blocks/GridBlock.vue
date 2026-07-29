<script setup lang="ts">
import type { Block } from '@/types/block'
import TitleBlock  from '@/components/editor/blocks/TitleBlock.vue'
import TextBlock   from '@/components/editor/blocks/TextBlock.vue'
import ImageBlock  from '@/components/editor/blocks/ImageBlock.vue'
import ButtonBlock from '@/components/editor/blocks/ButtonBlock.vue'
import DividerBlock from '@/components/editor/blocks/DividerBlock.vue'

const props = defineProps<{
    block: Block 
}>()

const emit = defineEmits<{
    (e: 'select', block: Block): void
    (e: 'delete', id: number): void
    (e: 'drop-block-grid', gridBlock: Block, row: number, col: number, type: Block['type']): void
}>()

const componentMap: Record<string, any> = {
    title:   TitleBlock,
    text:    TextBlock,
    image:   ImageBlock,
    button:  ButtonBlock,
    divider: DividerBlock,
}

function onDragOver(e: DragEvent) {
    e.preventDefault()
}

function onDrop(e: DragEvent, row: number, col: number) {
    e.preventDefault()
    e.stopPropagation()
    const type = e.dataTransfer?.getData('block-type') as Block['type']
    // Usiamo props.blockSelected invece di blockSelected direttamente per TS
    if (type && props.block) emit('drop-block-grid', props.block, row, col, type)
}
</script>

<template>
  <div class="grid w-full"
    :style="{ 
        gridTemplateColumns: `repeat(${block.props!.cols || 3}, 1fr)`,
        gap: (block.layout!.gap || 10) + 'px',
        backgroundColor: block.style?.backgroundColor,

        paddingTop: block.style?.padding?.top +'rem',
        paddingBottom: block.style?.padding?.bottom +'rem',
        paddingRight: block.style?.padding?.right +'rem',
        paddingLeft: block.style?.padding?.left +'rem',

        marginTop: block.style?.margin?.top +'rem',
        marginBottom: block.style?.margin?.bottom +'rem',
        marginRight: block.style?.margin?.right +'rem',
        marginLeft: block.style?.margin?.left+'rem',
    }"
     
  >
    <template  v-for="(row, rowIdx) in block.grid" :key="rowIdx">
      
      <div 
        v-for="(cell, colIdx) in row" 
        :key="colIdx"
        class="relative group border rounded border-dashed border-gray-300 min-h-[80px] flex items-center justify-center"
        data-grid-cell
        @drop.stop="onDrop($event, rowIdx, colIdx)"
        @dragover.prevent="onDragOver($event)"
      >
        <div v-if="cell" class="block-wrapper"
            :style="{ 
                    width: cell.style?.width ? cell.style.width + '%' : '100%',
                    height: cell.style?.height ? cell.style.height + '%' : '100%', 
            }"
            @click.stop="emit('select', cell)"
        >
            <div class="absolute top-2 right-2 hidden group-hover:flex gap-1 z-10">
                <button
                    class="w-6 h-6 flex items-center justify-center border rounded border-gray-200 bg-white text-gray-400 hover:text-red-500 text-xs"
                    @click.stop="emit('delete', cell.id)"
                >✕</button>
            </div>
            <component    :is="componentMap[cell.type]" 
                        :block="cell"
            />
        </div>

        <div v-else class="placeholder">
          <p class="text-gray-400 text-sm text-center"> Trascina qui </p>
        </div>
      </div>

    </template>
  </div>
</template>