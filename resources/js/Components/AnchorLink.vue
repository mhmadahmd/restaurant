<script setup>
import { computed } from "vue";
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: String,
    mode: {
        type: String,
        default: "add",
    },
});

const classes = computed(() => {
    if (props.mode == "add") {
        return "bg-emerald-500 hover:bg-emerald-800";
    }
    if (props.mode == "edit") {
        return "bg-sky-500 hover:bg-sky-800";
    }
    if (props.mode == "delete") {
        return "bg-rose-500 hover:bg-rose-800";
    }
    if (props.mode == "view") {
        return "bg-amber-500 hover:bg-amber-800";
    }
    return "";
});
</script>

<template>
    <Link
        :href="href"
        class="px-3 py-2 mr-2 rounded text-white text-sm font-bold whitespace-no-wrap"
        :class="classes"
    >
        <slot />
    </Link>
</template>
