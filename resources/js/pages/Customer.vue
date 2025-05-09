<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    customers: Array,
    editingCustomer: Object
});

const form = useForm({
    name: props.editingCustomer?.name || '',
    email: props.editingCustomer?.email || '',
    phone: props.editingCustomer?.phone || '',
    address: props.editingCustomer?.address || '',
    status: props.editingCustomer?.status || 'active'
});

const searchQuery = ref('');
const isEditing = ref(!!props.editingCustomer);

const submit = () => {
    if (isEditing.value) {
        form.put(route('customers.update', props.editingCustomer.id));
    } else {
        form.post(route('customers.store'));
    }
};

const editCustomer = (customer) => {
    router.visit(route('customers.index', { edit: customer.id }));
};

const cancelEdit = () => {
    router.visit(route('customers.index'));
};

const deleteCustomer = (id) => {
    if (confirm('Are you sure you want to delete this customer?')) {
        router.delete(route('customers.destroy', id));
    }
};
</script>

<template>
    <Head title="Customers" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800">Customer Management</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <!-- Customer Form -->
                        <div class="mb-8 p-4 border rounded-lg">
                            <h3 class="text-lg font-medium mb-4">
                                {{ isEditing ? 'Edit Customer' : 'Create New Customer' }}
                            </h3>

                            <form @submit.prevent="submit">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Name *</label>
                                        <input
                                            v-model="form.name"
                                            type="text"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"
                                            required
                                        >
                                        <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">
                                            {{ form.errors.name }}
                                        </p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Email *</label>
                                        <input
                                            v-model="form.email"
                                            type="email"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"
                                            required
                                        >
                                        <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">
                                            {{ form.errors.email }}
                                        </p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Phone</label>
                                        <input
                                            v-model="form.phone"
                                            type="text"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"
                                        >
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Status</label>
                                        <select
                                            v-model="form.status"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"
                                        >
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Address</label>
                                        <textarea
                                            v-model="form.address"
                                            rows="3"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"
                                        ></textarea>
                                    </div>
                                </div>

                                <div class="flex justify-end space-x-3 mt-4">
                                    <button
                                        v-if="isEditing"
                                        @click="cancelEdit"
                                        type="button"
                                        class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600"
                                    >
                                        Cancel
                                    </button>
                                    <button
                                        type="submit"
                                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 disabled:opacity-50"
                                        :disabled="form.processing"
                                    >
                                        {{ isEditing ? 'Update' : 'Create' }} Customer
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Customer List -->
                        <div>
                            <input
                                v-model="searchQuery"
                                type="text"
                                placeholder="Search customers..."
                                class="w-full mb-4 px-4 py-2 border rounded-lg"
                            >

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr v-for="customer in customers" :key="customer.id">
                                            <td class="px-6 py-4 whitespace-nowrap">{{ customer.name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ customer.email }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ customer.phone }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    :class="{
                                                        'bg-green-100 text-green-800': customer.status === 'active',
                                                        'bg-red-100 text-red-800': customer.status === 'inactive'
                                                    }"
                                                    class="px-2 py-1 text-xs font-semibold rounded-full"
                                                >
                                                    {{ customer.status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                                <button
                                                    @click="editCustomer(customer)"
                                                    class="text-blue-600 hover:text-blue-900"
                                                >
                                                    Edit
                                                </button>
                                                <button
                                                    @click="deleteCustomer(customer.id)"
                                                    class="text-red-600 hover:text-red-900"
                                                >
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
