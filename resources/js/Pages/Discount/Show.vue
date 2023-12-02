<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import DiscountListItem from "@/Components/DiscountListItem.vue";


defineProps({
    parent: Object,
    children: Array,
    type: String
});
</script>

<template>
    <Head title="Discount" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Discount - {{ parent ? parent.name : ''}}</h2>
        </template>

        <div class="py-12">
            <div
                class="max-w-7xl mx-auto bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
            >
                <ul role="list" class="divide-y divide-gray-100">
                    <DiscountListItem :items="children" :type="type"/>
                </ul>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
