<script setup lang="ts">
import { ref } from 'vue'
import type { Block } from '@/types/block'
import { blockDefaults } from '@/types/blockDefault'
import Sidebar from '@/components/editor/SidebarEditor.vue'
import Canvas from '@/components/editor/CanvasEditor.vue'
import SettingsPanelEditor from '@/components/editor/SettingsPanelEditor.vue'

// Array reattivo che contiene lo stato dei blocchi inseriti nel canvas
const blocks = ref<Block[]>([])
const selectedBlock = ref<Block | null>(null)

// Inserisce un blocco a livello root (nel canvas principale)
function addBlock(type: Block['type']) {
    const standard = structuredClone(blockDefaults[type])
    const block: Block = {
        ...standard,
        id: Date.now(),
        children: type === 'container' ? [] : undefined,
        grid: type === 'grid'
            ? Array(standard.props?.rows ?? 1)
                .fill(null)
                .map(() => Array(standard.props?.cols ?? 3).fill(null))
            : undefined
    }
    blocks.value.push(block)
    selectedBlock.value = block
}

// Inserisce un blocco dentro un Container
function addChildBlock(parent: Block, type: Block['type']) {
    const standard = structuredClone(blockDefaults[type])
    const child: Block = {
        ...standard,
        id: Date.now(),
        children: type === 'container' ? [] : undefined,
        grid: type === 'grid'
            ? Array(standard.props?.rows ?? 1)
                .fill(null)
                .map(() => Array(standard.props?.cols ?? 3).fill(null))
            : undefined
    }
    parent.children = [...(parent.children ?? []), child]
    selectedBlock.value = child
}

// Inserisce un blocco in una cella specifica di una Griglia (sia root che dentro container)
function addBlockToGrid(parent: Block, row: number, col: number, type: Block['type']) {
    const child: Block = { ...structuredClone(blockDefaults[type]), id: Date.now() }
    
    const idx = blocks.value.findIndex(b => b.id === parent.id)
    if (idx !== -1 && blocks.value[idx].grid) {
        const newGrid = blocks.value[idx].grid!.map(r => [...r])
        newGrid[row][col] = child
        blocks.value[idx].grid = newGrid
        selectedBlock.value = child
        return
    }

    for (const block of blocks.value) {
        if (!block.children) continue
        const childIdx = block.children.findIndex(c => c.id === parent.id)
        if (childIdx !== -1 && block.children[childIdx].grid) {
            const newGrid = block.children[childIdx].grid!.map(r => [...r])
            newGrid[row][col] = child
            block.children[childIdx].grid = newGrid
            selectedBlock.value = child
            return
        }
    }
}

function updateChildren(parent: Block, children: Block[]) {
    parent.children = children
}

function updateGrid(block: Block, grid: (Block | null)[][]) {
    const idx = blocks.value.findIndex(b => b.id === block.id)
    if (idx !== -1) {
        blocks.value[idx].grid = grid
        blocks.value[idx].props = block.props
        return
    }

    for (const b of blocks.value) {
        if (!b.children) continue
        const childIdx = b.children.findIndex(c => c.id === block.id)
        if (childIdx !== -1) {
            b.children[childIdx].grid = grid
            b.children[childIdx].props = block.props
            return
        }
    }
}

function selectBlock(block: Block) {
    selectedBlock.value = block
}

function deleteBlock(id: number) {
    blocks.value = blocks.value.filter(b => b.id !== id)
    blocks.value.forEach(b => {
        if (b.children) {
            b.children = b.children.filter(c => c.id !== id)
        }
        if (b.grid) {
            b.grid = b.grid.map(riga => 
                riga.map(cell => cell?.id === id ? null : cell)
            )
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
        <Sidebar/>
        <Canvas
            :blocks="blocks"
            :selected-id="selectedBlock?.id ?? null"
            @select="selectBlock"
            @delete="deleteBlock"
            @drop-block="addBlock"
            @update:blocks="blocks = $event"
            @drop-block-in-container="addChildBlock"
            @drop-block-in-grid="addBlockToGrid"
            @update-children="updateChildren"
        />
        <SettingsPanelEditor 
            :block="selectedBlock"
            :blocks="blocks"
            @saved="onSaved"
            @update-grid="updateGrid"
        />
    </div>
</template>