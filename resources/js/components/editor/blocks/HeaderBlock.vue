<script setup lang="ts">
import { computed } from 'vue'
import { inject, type Ref } from 'vue'
import { VueDraggable } from 'vue-draggable-plus'
import type { Block } from '@/types/block'
import TitleBlock   from '@/components/editor/blocks/TitleBlock.vue'
import TextBlock    from '@/components/editor/blocks/TextBlock.vue'
import ImageBlock   from '@/components/editor/blocks/ImageBlock.vue'
import ButtonBlock  from '@/components/editor/blocks/ButtonBlock.vue'
import DividerBlock from '@/components/editor/blocks/DividerBlock.vue'
import HTMLBlock from '@/components/editor/blocks/HTMLBlock.vue'
import ContainerBlock from './ContainerBlock.vue' 

const props = defineProps<{
    block: Block
}>()

//recupero l'id selezionato come inject da EditorTemplate che lo ha dichiarato provide
const selectedId = inject<Ref<number | null>>('selectedId')


const emit = defineEmits<{
    (e: 'select', block: Block): void
    (e: 'delete', id: number): void
    //Passo sia blocco contenitore di destinazione che il tipo
    (e: 'drop-block', targetBlock: Block, type: Block['type']): void
    (e: 'update:children', children: Block[]): void
}>()

const componentMap: Record<string, any> = {
    title:     TitleBlock,
    text:      TextBlock,
    image:     ImageBlock,
    button:    ButtonBlock,
    divider:   DividerBlock,
    html:      HTMLBlock,
    container: ContainerBlock 
}

const children = computed({
    get: () => props.block.children ?? [],
    set: (val) => emit('update:children', val)
})


function onDragOver(e: DragEvent) {
    e.preventDefault()
    e.stopPropagation()
    if (e.dataTransfer) {
        e.dataTransfer.dropEffect = 'copy'
    }
}

function onDrop(e: DragEvent) {
    e.preventDefault()
    e.stopPropagation()

    // Quando riordini o scambi due blocchi esistenti con VueDraggable, 
    // l'evento di rilascio NON arriva dalla Sidebar e non ha il "block-type".
    const type = e.dataTransfer?.getData('block-type') as Block['type']
    
    // Se non c'è un block-type valido, significa che è un semplice riordinamento interno. 
    // Blocchiamo tutto e NON creiamo nessun blocco!
    if (!type) {
        return 
    }

    // Whitelist dei tipi ammessi dalla Sidebar
    const validTypes = ['container', 'title', 'text', 'image', 'button', 'divider', 'html']
    if (!validTypes.includes(type)) {
        return
    }

    // Se è un vero blocco proveniente dalla Sidebar, procedi
    emit('drop-block', props.block, type)
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
        class="w-full relative border border-stone-200 bg-stone-50/40 rounded-xl"
        @dragover="onDragOver"
        @drop="onDrop"
    >
        <VueDraggable
            v-model="children"
            data-container
            group="inner-blocks"
            :style="{
                display: block.layout?.display,
                flexDirection: block.layout?.flexDirection,
                alignItems: block.layout?.alignItems,
                justifyContent: block.layout?.justifyContent,
                gap: block.layout?.gap + 'px',
                flexWrap: block.layout?.flexWrap,
                alignContent: block.layout?.alignContent
            }"
            class="w-full min-h-[60px] p-2"
        >
            <div
                v-for="child in children"
                :key="child.id"
                class="relative group border border-stone-200 rounded-lg bg-white cursor-pointer hover:border-blue-400/80 transition"
                :style="{ 
                    width: child.style?.width ? child.style.width + '%' : '100%',
                    height: child.style?.height ? child.style.height + 'px' : '100%', 
                }"
                @click.stop="emit('select', child)"
            >
                <!-- Pulsante elimina elemento interno -->
                <div 
                    v-if="selectedId === child.id" 
                    class="absolute top-2 right-2 flex gap-1 z-10"
                >
                    <button
                        class="w-5 h-5 flex items-center justify-center rounded border border-stone-200 bg-white text-stone-400 hover:text-red-500 hover:border-red-200 text-[10px] shadow-sm transition"
                        @click.stop="emit('delete', child.id)"
                    >✕</button>
                </div>
                
                <!-- Il componente dinamico ora gestirà anche i container figli in modo ricorsivo -->
                <component  
                    :is="componentMap[child.type]" 
                    :block="child"
                    @select="(b: Block) => emit('select', b)"  
                    @delete="(id: number) => emit('delete', id)"
                    @drop-block="(targetBlock: Block, type: Block['type']) => emit('drop-block', targetBlock, type)"
                    @update:children="(newChildren: Block[]) => child.children = newChildren"
                />
            </div>
        </VueDraggable>

        <p v-if="!block.children?.length" class="text-stone-400 text-sm text-center py-6">
            Trascina un elemento o un sotto-contenitore qui
        </p>
    </header>
</template>