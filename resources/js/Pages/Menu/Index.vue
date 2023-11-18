<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import AnchorLink from '@/Components/AnchorLink.vue';
defineProps({
    menus: {
        type: Object,
    },
});
</script>

<template>
    <Head title="Menu" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Menu</h2>
        </template>

        <div class="py-12">
            <div class="grid grid-cols-3 gap-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-for="menu in menus" :key="menu.id">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100 lg:flex lg:items-center lg:justify-between">
                            <span>{{ menu.name }}</span>

                            <AnchorLink :href="route('menus.show', menu.id)" mode="view">Show</AnchorLink>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
