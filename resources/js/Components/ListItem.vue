<script setup>
import AnchorLink from "@/Components/AnchorLink.vue";
import { EyeIcon, TrashIcon } from "@heroicons/vue/20/solid";
const props = defineProps({
    items: Array,
    type: {
        type: String,
        default: 'menu'
    }
});
</script>

<template>
    <li v-for="item in items"
        :key="item.id"
        class="flex justify-between gap-x-6 py-5 px-4 sm:px-6 lg:px-8">
        <div class="flex min-w-0 gap-x-4 self-center">
            <h2 class="font-semibold text-gray-900 dark:text-gray-100">
                {{ item.name }}
            </h2>
        </div>
        <div>

            <AnchorLink v-if="type != 'item'" :data="{m: item.id}" :href="route('categories.index')" mode="view">
                <EyeIcon class="h-5 w-5 inline" />
                <span class="hidden md:inline ml-2">Show</span>
            </AnchorLink>
            <AnchorLink
                :href="type == 'menu' ? route('menus.destroy', item.id) : route('items.destroy', item.id)"
                method="delete"
                mode="delete"
            >
                <TrashIcon class="h-5 w-5 inline" />
                <span class="hidden md:inline ml-2">Delete</span>
            </AnchorLink>
        </div>
    </li>
</template>
