<script setup>
import AnchorLink from "@/Components/AnchorLink.vue";
import TreeList from "@/Components/TreeList.vue";
import { EyeIcon, TrashIcon } from "@heroicons/vue/20/solid";
const props = defineProps({
    list: Array,
});
</script>

<template>
    <li v-for="item in list" :key="item.id">
        <div class="flex justify-between gap-x-6 py-5 px-4 sm:px-6 lg:px-8 border-b" >
            <div class="flex min-w-0 gap-x-4 self-center" :style="{ 'padding-left': item.depth + 'rem' }">
                <h2 class="font-semibold text-gray-900 dark:text-gray-100">
                    {{ item.name }}
                </h2>
            </div>
            <div>
                <AnchorLink :href="route('categories.show', item.id)" mode="view">
                    <EyeIcon class="h-5 w-5 inline" />
                    <span class="hidden md:inline ml-2">Show</span>
                </AnchorLink>
                <AnchorLink
                    :href="route('categories.destroy', item.id)"
                    method="delete"
                    mode="delete"
                >
                    <TrashIcon class="h-5 w-5 inline" />
                    <span class="hidden md:inline ml-2">Delete</span>
                </AnchorLink>
            </div>
        </div>

        <TreeList :list="item.children" v-if="item.children.length"/>
    </li>
</template>
