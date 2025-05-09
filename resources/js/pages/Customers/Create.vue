<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    phone: '',
    address: '',
    status: 'active'
});
</script>

<template>
    <Head title="Create Customer" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create New Customer</h2>
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
                        <form @submit.prevent="form.post(route('customers.store'))">
                            <div class="grid grid-cols-1 gap-6 mt-4">
                                <div>
                                    <label class="block text-sm text-gray-700">Name</label>
                                    <input
                                        v-model="form.name"
                                        type="text"
                                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border rounded-lg"
                                        required
                                    >
                                    <p v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm text-gray-700">Email</label>
                                    <input
                                        v-model="form.email"
                                        type="email"
                                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border rounded-lg"
                                        required
                                    >
                                    <p v-if="form.errors.email" class="text-red-500 text-xs mt-1">{{ form.errors.email }}</p>
                                </div>

                                <!-- Add other fields (phone, address, status) similarly -->

                                <div class="flex justify-end mt-6">
                                    <button
                                        type="submit"
                                        class="px-6 py-2 leading-5 text-white bg-blue-500 rounded-lg hover:bg-blue-600"
                                        :disabled="form.processing"
                                    >
                                        <span v-if="form.processing">Saving...</span>
                                        <span v-else>Save Customer</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
