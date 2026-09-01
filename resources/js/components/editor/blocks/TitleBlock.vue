<script setup lang="ts">
import type { Block } from '@/types/block'
defineProps<{ block: Block }>()
</script>

<template
>
    <div
    >
        <h1 
            :style="{ 
                fontFamily: block.style?.fontFamily,
                fontSize: block.style?.fontSize + 'px', 
                fontWeight: block.style?.fontWeight,
                fontStyle: block.style?.fontStyle,
                textDecoration: block.style?.textDecoration,
                color: block.style?.color,
                lineHeight: block.style?.lineHeight,
                letterSpacing: block.style?.letterSpacing,
                wordSpacing: block.style?.wordSpacing + 'rem',
                textAlign: block.style?.textAlign,
                wordBreak: block.style?.wordBreak,
                alignItems: block.layout?.alignItems,

                marginTop: block.style?.margin?.top +'rem',
                marginBottom: block.style?.margin?.bottom +'rem',
                marginRight: block.style?.margin?.right +'rem',
                marginLeft: block.style?.margin?.left +'rem',

                paddingTop: block.style?.padding?.top +'rem',
                paddingBottom: block.style?.padding?.bottom +'rem',
                paddingRight: block.style?.padding?.right +'rem',
                paddingLeft: block.style?.padding?.left +'rem',


            }" 
        >
            {{ block.props?.text }}
        </h1>
    </div>
</template>