<script setup lang="ts">
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

// recupero l'id selezionato come inject dal padre che lo ha dichiarato provide
const selectedId = inject<Ref<number | null>>('selectedId')

const emit = defineEmits<{
    (e: 'select', block: Block): void
    (e: 'delete', id: number): void
    (e: 'drop-block', payload: { type: Block['type']; targetIndex?: number }): void
    (e: 'update-children', parent: Block, children: Block[]): void
    (e: 'drop-block-in-container', parent: Block, type: Block['type']): void
}>()

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

function onDrop(e: DragEvent, currentBlock: Block) {
    e.preventDefault()
    
    const target = e.target as HTMLElement
    const isInsideChildContainer = target.closest('[data-container]')
    if (isInsideChildContainer) return

    const type = (e.dataTransfer?.getData('block-type') || e.dataTransfer?.getData('text/plain')) as Block['type']
    
    if (type) {
        // Invece di 'drop-block', emettiamo direttamente l'evento per il container passandogli il blocco 555555
        emit('drop-block-in-container', currentBlock, type)
    }
}

</script>

<template>
    <main class="flex-1 bg-gray-100 overflow-y-auto p-8 h-full">
        <!-- Contenitore statico dei blocchi di root -->
        <div class="flex flex-col gap-4 max-w-5xl mx-auto min-h-[500px] p-2">
            <div
                v-for="block in props.blocks"
                :key="block.id"
                class="relative group rounded-lg border transition-all w-full select-none"
                :class="[
                    // Sfondo bianco per il 555555, sfondo grigino (stone-100) per tutti gli altri blocchi di root
                    block.id === 555555 
                        ? 'bg-white cursor-pointer'
                        : 'bg-white cursor-not-allowed' ,
                    
                    // Mostra il bordo blu di selezione SOLO ed esclusivamente se il blocco è il 555555
                    selectedId === block.id && block.id === 555555
                        ? 'border-blue-500 border-[1.5px] shadow-sm'
                        : 'border-gray-200'
                ]"
                :style="{
                    width: block.style?.width ? block.style?.width + '%' : '100%',
                    minHeight: block.style?.minHeight ? block.style?.minHeight + 'vh' : '',
                    marginInline: block.style?.textAlign === 'center' ? 'auto' : 
                                   (block.style?.textAlign === 'right' ? '0 0 0 auto' : '0')
                }"
                @click.stop="block.id === 555555 ? emit('select', block) : null"
            >
                <!-- Etichetta per tipo blocco -->
                <div 
                    v-if="![555555].includes(block.id)"
                    class="absolute -top-3 left-3 px-2 py-0.5 rounded text-[10px] font-semibold uppercase tracking-wider z-20 pointer-events-none transition-opacity bg-stone-800 text-white opacity-0 group-hover:opacity-100"
                >
                    {{ block.type }}
                </div>

                <div class="p-4">
                    <!-- Blocco Content -->
                    <div 
                        v-if="block.id === 555555"
                        class="flex flex-col gap-2"
                        @dragover="onDragOver"
                        @drop.stop="onDrop($event, block)"
                    >
                        <VueDraggable
                            v-if="block.children"
                            v-model="block.children"
                            @update:model-value="(children: Block[]) => emit('update-children', block, children)"
                            class="flex flex-col gap-3 min-h-[150px] p-2 bg-transparent"
                            group="nested-blocks"
                            :animation="150"
                        >
                            <div
                                v-for="child in block.children"
                                :key="child.id"
                                class="p-3 bg-white rounded border border-stone-200 cursor-pointer relative group/child"
                                :class="{ 'border-blue-500 ring-1 ring-blue-500': selectedId === child.id }"
                                @click.stop="emit('select', child)"
                            >
                                <button
                                    v-if="selectedId === child.id"
                                    class="absolute top-2 right-2 w-5 h-5 flex items-center justify-center rounded bg-white border border-stone-200 text-stone-500 hover:text-red-500 text-xs z-10 shadow-sm"
                                    @click.stop="emit('delete', child.id)"
                                >✕</button>

                                <component 
                                    :is="componentMap[child.type]" 
                                    :block="child"
                                    :selected-id="selectedId"
                                    @select="(b: Block) => emit('select', b)"
                                    @delete="(id: number) => emit('delete', id)"
                                    @drop-block="(targetBlock: Block, type: Block['type']) => emit('drop-block-in-container', targetBlock, type)"
                                    @update:children="(children: Block[]) => emit('update-children', child, children)"
                                />
                            </div>
                        </VueDraggable>
                    </div>

                    <!-- Componenti di root -->
                    <component 
                        v-else
                        :is="componentMap[block.type]" 
                        :block="block"
                        :selected-id="selectedId"
                        :is-locked="true"
                        class="cursor-not-allowed"
                        @drop-block="(targetBlock: Block, type: Block['type']) => emit('drop-block-in-container', targetBlock, type)"
                        @update:children="(children: Block[]) => emit('update-children', block, children)"
                        @select="(b: Block) => {}"
                        @delete="(id: number) => emit('delete', id)"
                    />
                </div>
            </div>
        </div>
    </main>
</template>