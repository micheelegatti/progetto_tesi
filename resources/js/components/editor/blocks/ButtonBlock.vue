<script setup lang="ts">
import type { Block } from '@/types/block'
defineProps<{ block: Block }>()
</script>
<template>
    <button
        :style="{ 
            backgroundColor: block.style?.backgroundColor,
            color: block.style?.color,
            fontSize: block.style?.fontSize + 'px',
            fontWeight: block.style?.fontWeight,
            fontFamily: block.style?.fontFamily,
            fontStyle: block.style?.fontStyle,
            textDecoration: block.style?.textDecoration,
            lineHeight: block.style?.lineHeight,
            letterSpacing: block.style?.letterSpacing,
            wordSpacing: block.style?.wordSpacing + 'rem',
            textAlign: block.style?.textAlign,
            wordBreak: block.style?.wordBreak,

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
        class="cursor-pointer w-full h-full"
    >
        {{ block.props?.text }}
    </button>
</template>