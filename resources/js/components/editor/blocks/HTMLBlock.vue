<script setup lang="ts">
import type { Block } from '@/types/block'
defineProps<{ block: Block }>()
</script>
<template>
    <div 
        :style="{ 
            marginTop: block.style?.margin?.top +'rem',
            marginBottom: block.style?.margin?.bottom +'rem',
            marginRight: block.style?.margin?.right +'rem',
            marginLeft: block.style?.margin?.left +'rem',

            paddingTop: block.style?.padding?.top +'rem',
            paddingBottom: block.style?.padding?.bottom +'rem',
            paddingRight: block.style?.padding?.right +'rem',
            paddingLeft: block.style?.padding?.left +'rem',
        }" 
        v-html="block.props?.text" 
    >
    </div>
</template>