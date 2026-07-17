<script setup lang="ts">
import { computed } from'vue'
import { VueDraggable } from 'vue-draggable-plus'
import type { Block } from '@/types/block'
import TitleBlock   from '@/components/editor/blocks/TitleBlock.vue'
import TextBlock    from '@/components/editor/blocks/TextBlock.vue'
import ImageBlock   from '@/components/editor/blocks/ImageBlock.vue'
import ButtonBlock  from '@/components/editor/blocks/ButtonBlock.vue'
import DividerBlock from '@/components/editor/blocks/DividerBlock.vue'
import GridBlock from '@/components/editor/blocks/GridBlock.vue'

const props = defineProps<{
    block: Block
}>()

const emit = defineEmits<{
    (e: 'select', block: Block): void
    (e: 'delete', id: number): void
    (e: 'drop-block', type: Block['type']): void
    (e: 'update:children', children: Block[]): void
    (e: 'drop-block-grid', gridBlock: Block, row: number, col: number, type: Block['type']): void
}>()

const componentMap: Record<string, any> = {
    title:   TitleBlock,
    text:    TextBlock,
    image:   ImageBlock,
    button:  ButtonBlock,
    divider: DividerBlock,
    grid: GridBlock,
}

const children = computed({
  get: () => props.block.children ?? [],
  //al posto che cambiare il props passo la cosa al padre
  set: (val) => emit('update:children', val)
})

function onDragOver(e: DragEvent) {
    e.preventDefault()
}

function onDrop(e: DragEvent) {
    e.preventDefault()
    e.stopPropagation()
    // Se il drop è avvenuto su una cella della griglia, ignora
    if ((e.target as HTMLElement).closest('[data-grid-cell]')){
         return
    } 
    const type = e.dataTransfer?.getData('block-type') as Block['type']
    if (type) emit('drop-block', type)
}
</script>

<template>
    <header
        data-container
        :style="{
            minHeight: block.style?.minHeight + 'vh',

            borderRadius: block.style?.border?.radius + 'px',
            borderWidth: block.style?.border?.width + 'px',
            borderColor: block.style?.border?.color,
            borderStyle: block.style?.border?.style,

            paddingTop: block.style?.padding?.top +'rem',
            paddingBottom: block.style?.padding?.bottom +'rem',
            paddingRight: block.style?.padding?.right +'rem',
            paddingLeft: block.style?.padding?.left +'rem',

            marginTop: block.style?.margin?.top +'rem',
            marginBottom: block.style?.margin?.bottom +'rem',
            marginRight: block.style?.margin?.right +'rem',
            marginLeft: block.style?.margin?.left+'rem',

            boxShadow: 
                `${block.style?.boxShadow?.offsetX ?? 0}px 
                ${block.style?.boxShadow?.offsetY ?? 0}px 
                ${block.style?.boxShadow?.blurRadius ?? 0}px 
                ${block.style?.boxShadow?.spreadRadius ?? 0}px 
                ${block.style?.boxShadow?.color ?? 'rgba(0,0,0,0)'}`
        }"
        class="w-full"
        @dragover ="onDragOver"
        @drop ="onDrop"
    >
        <VueDraggable
            v-model="children"
            data-container
            group="blocks"
            :style="{
                display: block.layout?.display,
                flexDirection: block.layout?.flexDirection,
                alignItems: block.layout?.alignItems,
                justifyContent: block.layout?.justifyContent,
                gap: block.layout?.gap + 'px',
                flexWrap: block.layout?.flexWrap,
                alignContent: block.layout?.alignContent
            }"
        >
            <div
                v-for="child in children"
                :key="child.id"
                class="relative group border border-gray-200 rounded-lg bg-white cursor-pointer hover:border-blue-400"
                :style="{ 
                    width: child.style?.width ? child.style.width + '%' : '100%',
                    height: child.style?.height ? child.style.height + 'px' : '100%', 
                }"
                @click.stop="emit('select', child)"
            >
                <div class="absolute top-2 right-2 hidden group-hover:flex gap-1 z-10">
                    <button
                        class="w-6 h-6 flex items-center justify-center rounded border border-gray-200 bg-white text-gray-400 hover:text-red-500 text-xs"
                        @click.stop="emit('delete', child.id)"
                    >✕</button>
                </div>
                <component  :is="componentMap[child.type]" 
                            :block="child"
                            @drop-block-grid="(gridBlock: Block, row: number, col: number, type: Block['type']) => emit('drop-block-grid', gridBlock, row, col, type)"
                            @select="(b: Block) => emit('select', b)"  />
            </div>
        </VueDraggable>

        <p v-if="!block.children?.length" class="text-gray-400 text-sm text-center">
            Trascina un elemento qui
        </p>
    </header>
</template>