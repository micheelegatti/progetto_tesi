<script setup lang="ts">
import type { Block } from '@/types/block'
import Divider from 'primevue/divider';
defineProps<{ block: Block }>()
</script>
<template>
    <Divider 
            :align="block.style?.textAlign || 'center'"  class="my-divider"
            :style="{
                fontSize: block.style?.fontSize,
                fontFamily: block.style?.fontFamily,
                borderTopWidth: block.style?.borderTopWidth,
                borderTopStyle: block.style?.borderTopStyle,
                borderTopColor: block.style?.borderTopColor,
                width: block.style?.width + '%',
                height: block.style?.height + 'px',
                
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
        {{block.props?.text }}
    </Divider>

    <!--
    <hr :style="{ 
        borderColor: block.style?.backgroundColor,
        width: block.style?.width + '%',
        height: block.style?.height + 'px',
    }" class="my-1" />
    -->
</template>