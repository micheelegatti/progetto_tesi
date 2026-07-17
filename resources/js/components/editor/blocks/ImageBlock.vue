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
            width: block.style?.width + '%',
            height: block.style?.height ? `${block.style.height}%` : 'auto',
            maxWidth: block.style?.maxWidth + '%',
            objectFit: block.style?.objectFit,
            objectPosition: block.style?.objectPosition,
            opacity: block.style?.opacity,

            marginTop: block.style?.margin?.top +'rem',
            marginBottom: block.style?.margin?.bottom +'rem',
            marginRight: block.style?.margin?.right +'rem',
            marginLeft: block.style?.margin?.left +'rem',

            paddingTop: block.style?.padding?.top +'rem',
            paddingBottom: block.style?.padding?.bottom +'rem',
            paddingRight: block.style?.padding?.right +'rem',
            paddingLeft: block.style?.padding?.left +'rem',
            
            borderRadius: block.style?.border?.radius + 'px',
            borderWidth: block.style?.border?.width + 'px',
            borderColor: block.style?.border?.color,
            borderStyle: block.style?.border?.style,
            
            boxShadow: 
                `${block.style?.boxShadow?.offsetX ?? 0}px 
                ${block.style?.boxShadow?.offsetY ?? 0}px 
                ${block.style?.boxShadow?.blurRadius ?? 0}px 
                ${block.style?.boxShadow?.spreadRadius ?? 0}px 
                ${block.style?.boxShadow?.color ?? 'rgba(0,0,0,0)'}`
        }"
        :layout="{
            display: block.layout?.display
        }"
    />
</template>