<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import Select from "@/Components/Select.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";

const props = defineProps({
    type: String,
    discount: Object,
    id: Number
});

const form = useForm({
    amount: props.discount ? props.discount.amount : null,
    type: props.type,
});

function submit() {
    form.put(route("discounts.update", props.id), {
        onSuccess: () => form.reset(),
    });
}
</script>

<template>
    <Head title="Edit Discount" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Edit Discount
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg py-5 px-4 sm:px-6 lg:px-8"
                >
                    <form @submit.prevent="submit">
                        <div class="mt-6">
                            <InputLabel for="amount" value="amount" />

                            <TextInput
                                id="amount"
                                ref="amountInput"
                                v-model="form.amount"
                                type="number"
                                max="100"
                                min="0"
                                class="mt-1 block w-full"
                                placeholder="amount"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.name"
                            />
                        </div>

                        <input type="hidden" name="type" v-model="form.type">

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
