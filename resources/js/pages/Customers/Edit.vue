<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    customer: {
        type: Object,
        required: true
    }
});

const form = useForm({
    name: props.customer.name,
    email: props.customer.email,
    phone: props.customer.phone,
    address: props.customer.address,
    status: props.customer.status
});
</script>

<template>
    <Head title="Edit Customer" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Customer</h2>
                <Link
                    :href="route('customers.index')"
                    class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600"
                >
                    Back to Customers
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="form.put(route('customers.update', customer.id))">
                            <!-- Same form fields as Create.vue -->
                            <!-- ... -->

                            <div class="flex justify-end mt-6 space-x-4">
                                <button
                                    type="submit"
                                    class="px-6 py-2 leading-5 text-white bg-blue-500 rounded-lg hover:bg-blue-600"
                                    :disabled="form.processing"
                                >
                                    <span v-if="form.processing">Updating...</span>
                                    <span v-else>Update Customer</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
