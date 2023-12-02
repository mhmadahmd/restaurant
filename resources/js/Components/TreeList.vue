<script setup>
import TreeLeaf from './TreeLeaf.vue';

const props = defineProps({
    list: Array,
});
</script>

<template>
    <ul role="list" class="">
        <TreeLeaf :list="list"></TreeLeaf>
    </ul>
</template>
