<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    proposals: Array,
    customers: Array,
    editingProposal: Object
});

const form = useForm({
    customer_id: props.editingProposal?.customer_id || '',
    title: props.editingProposal?.title || '',
    description: props.editingProposal?.description || '',
    amount: props.editingProposal?.amount || 0,
    proposal_date: props.editingProposal?.proposal_date || new Date().toISOString().split('T')[0],
    expiry_date: props.editingProposal?.expiry_date || new Date(Date.now() + 30 * 24 * 60 * 60 * 1000).toISOString().split('T')[0],
    status: props.editingProposal?.status || 'draft'
});

const searchQuery = ref('');
const isEditing = ref(!!props.editingProposal);

const submit = () => {
    if (isEditing.value) {
        form.put(route('proposals.update', props.editingProposal.id));
    } else {
        form.post(route('proposals.store'));
    }
};

const editProposal = (proposal) => {
    router.visit(route('proposals.index', { edit: proposal.id }));
};

const cancelEdit = () => {
    router.visit(route('proposals.index'));
};

const deleteProposal = (id) => {
    if (confirm('Are you sure you want to delete this proposal?')) {
        router.delete(route('proposals.destroy', id));
    }
};

const statusClasses = {
    draft: 'bg-gray-100 text-gray-800',
    sent: 'bg-blue-100 text-blue-800',
    accepted: 'bg-green-100 text-green-800',
    rejected: 'bg-red-100 text-red-800'
};
</script>

<template>
    <Head title="Proposals" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800">Proposal Management</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <!-- Proposal Form -->
                        <div class="mb-8 p-4 border rounded-lg">
                            <h3 class="text-lg font-medium mb-4">
                                {{ isEditing ? 'Edit Proposal' : 'Create New Proposal' }}
                            </h3>

                            <form @submit.prevent="submit">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Customer *</label>
                                        <select
                                            v-model="form.customer_id"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"
                                            required
                                        >
                                            <option value="">Select Customer</option>
                                            <option
                                                v-for="customer in customers"
                                                :key="customer.id"
                                                :value="customer.id"
                                            >
                                                {{ customer.name }} ({{ customer.email }})
                                            </option>
                                        </select>
                                        <p v-if="form.errors.customer_id" class="mt-1 text-sm text-red-600">
                                            {{ form.errors.customer_id }}
                                        </p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Title *</label>
                                        <input
                                            v-model="form.title"
                                            type="text"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"
                                            required
                                        >
                                        <p v-if="form.errors.title" class="mt-1 text-sm text-red-600">
                                            {{ form.errors.title }}
                                        </p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Amount *</label>
                                        <input
                                            v-model="form.amount"
                                            type="number"
                                            min="0"
                                            step="0.01"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"
                                            required
                                        >
                                        <p v-if="form.errors.amount" class="mt-1 text-sm text-red-600">
                                            {{ form.errors.amount }}
                                        </p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Proposal Date *</label>
                                        <input
                                            v-model="form.proposal_date"
                                            type="date"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"
                                            required
                                        >
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Expiry Date *</label>
                                        <input
                                            v-model="form.expiry_date"
                                            type="date"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"
                                            required
                                        >
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Status</label>
                                        <select
                                            v-model="form.status"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"
                                        >
                                            <option value="draft">Draft</option>
                                            <option value="sent">Sent</option>
                                            <option value="accepted">Accepted</option>
                                            <option value="rejected">Rejected</option>
                                        </select>
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Description *</label>
                                        <textarea
                                            v-model="form.description"
                                            rows="4"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"
                                            required
                                        ></textarea>
                                        <p v-if="form.errors.description" class="mt-1 text-sm text-red-600">
                                            {{ form.errors.description }}
                                        </p>
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
                                        {{ isEditing ? 'Update' : 'Create' }} Proposal
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Proposal List -->
                        <div>
                            <input
                                v-model="searchQuery"
                                type="text"
                                placeholder="Search proposals..."
                                class="w-full mb-4 px-4 py-2 border rounded-lg"
                            >

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Expiry Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr v-for="proposal in proposals" :key="proposal.id">
                                            <td class="px-6 py-4 whitespace-nowrap">{{ proposal.title }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ proposal.customer.name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">${{ proposal.amount.toLocaleString() }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    :class="statusClasses[proposal.status]"
                                                    class="px-2 py-1 text-xs font-semibold rounded-full"
                                                >
                                                    {{ proposal.status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ proposal.expiry_date }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                                <button
                                                    @click="editProposal(proposal)"
                                                    class="text-blue-600 hover:text-blue-900"
                                                >
                                                    Edit
                                                </button>
                                                <button
                                                    @click="deleteProposal(proposal.id)"
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
