<script setup>
import { computed } from 'vue';

const props = defineProps({
    items: Array,
    selected: [Array, String]
});

const emit = defineEmits(['update:selected']);
const proxySelected = computed({
    get() {
        return props.selected;
    },

    set(val) {
        emit('update:selected', val);
    },
});

</script>

<template>
    <select
        v-model="proxySelected"
        class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
    >
        <option v-for="item in items" :key="item.id" :value="item.id">{{ item.name }}</option>
    </select>
</template>
