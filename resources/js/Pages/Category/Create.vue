<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import Select from "@/Components/Select.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";

const props = defineProps({
    menu_id: Number,
    parent_id: Number,
});

const form = useForm({
    name: "",
    menu_id: props.menu_id,
    parent_id: props.parent_id,
});

function submit() {
    form.post(route("categories.store"), {
        onSuccess: () => form.reset(),
    });
}
</script>

<template>
    <Head title="Create Category" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                <span v-if="menu_id">Create New Category</span>
                <span v-else>Create New Sub Category</span>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg py-5 px-4 sm:px-6 lg:px-8"
                >
                    <form @submit.prevent="submit">
                        <div class="mt-6">
                            <InputLabel for="name" value="Name" />

                            <TextInput
                                id="name"
                                ref="nameInput"
                                v-model="form.name"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Name"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.name"
                            />
                        </div>

                        <input type="hidden" name="menu_id" v-model="form.menu_id">
                        <input type="hidden" name="parent_id" v-model="form.parent_id">

                        <div class="mt-6 flex justify-end">
                            <PrimaryButton
                                class="ms-3"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                                type="submit"
                            >
                                Submit
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
