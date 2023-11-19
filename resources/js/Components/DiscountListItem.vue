<script setup>
import AnchorLink from "@/Components/AnchorLink.vue";
import { PencilSquareIcon, EyeIcon } from "@heroicons/vue/20/solid";
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
                <small class="text-xs leading-5 text-gray-500" v-if="item.discount" > Discount Amount: {{ item.discount.amount }} %</small>
            </h2>
        </div>
        <div>
            <AnchorLink v-if="type != 'item'" :href="route('discounts.show', item.id)" :data="{type: type}" mode="view">
                <EyeIcon class="h-5 w-5 inline" />
                <span class="hidden md:inline ml-2">Show</span>
            </AnchorLink>
            <AnchorLink :href="route('discounts.edit', item.id)" :data="{type: type}" mode="edit">
                <PencilSquareIcon class="h-5 w-5 inline" />
                <span class="hidden md:inline ml-2">Edit</span>
            </AnchorLink>
        </div>
    </li>
</template>
