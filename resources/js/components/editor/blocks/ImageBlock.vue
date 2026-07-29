<script setup lang="ts">
import type { Block } from '@/types/block'
defineProps<{ block: Block }>()
</script>

<template>
    <div v-if="!block.props?.src" class="bg-gray-100 rounded-lg h-40 flex items-center justify-center text-gray-400 text-sm">
        Nessuna immagine
    </div>
    <img 
        v-else 
        :src="block.props.src" 
        :alt="block.props.alt" 
        :style="{
            width: (block.style?.width ?? 100) + '%',
            height: 'auto',
            maxWidth: '100%',
            objectFit: block.style?.objectFit ?? 'contain',
            objectPosition: block.style?.objectPosition ?? 'center',
            opacity: block.style?.opacity ?? 1,
            display: (block.layout?.display && block.layout.display !== 'none') ? block.layout.display : 'inline-block',

            marginTop: (block.style?.margin?.top ?? 0) + 'rem',
            marginBottom: (block.style?.margin?.bottom ?? 0) + 'rem',
            marginRight: (block.style?.margin?.right ?? 0) + 'rem',
            marginLeft: (block.style?.margin?.left ?? 0) + 'rem',

            paddingTop: (block.style?.padding?.top ?? 0) + 'rem',
            paddingBottom: (block.style?.padding?.bottom ?? 0) + 'rem',
            paddingRight: (block.style?.padding?.right ?? 0) + 'rem',
            paddingLeft: (block.style?.padding?.left ?? 0) + 'rem',
            
            borderRadius: (block.style?.border?.radius ?? 0) + 'px',
            borderWidth: (block.style?.border?.width ?? 0) + 'px',
            borderColor: block.style?.border?.color,
            borderStyle: block.style?.border?.style,
            
            boxShadow: 
                `${block.style?.boxShadow?.offsetX ?? 0}px 
                ${block.style?.boxShadow?.offsetY ?? 0}px 
                ${block.style?.boxShadow?.blurRadius ?? 0}px 
                ${block.style?.boxShadow?.spreadRadius ?? 0}px 
                ${block.style?.boxShadow?.color ?? 'rgba(0,0,0,0)'}`
        }"
    />
</template>