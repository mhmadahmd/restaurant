<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import AnchorLink from "@/Components/AnchorLink.vue";
import TreeList from "@/Components/TreeList.vue";
import { PlusIcon } from "@heroicons/vue/20/solid";

defineProps({
    tree: {
        type: Array,
    },
    menu_id: {
        type: Number
    }
});
</script>

<template>
    <Head title="Menu" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Category Tree
            </h2>
        </template>

        <template #page_actions>
            <AnchorLink :href="route('categories.create')" :data="{menu: menu_id}" >
                <PlusIcon class="h-5 w-5 inline" />
                <span class="hidden md:inline ml-2">Create</span>
            </AnchorLink>
        </template>

        <div class="py-12">
            <div
                class="max-w-7xl mx-auto bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
            >
                <TreeList :list="tree"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
