<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    invoices: Array,
    customers: Array,
    editingInvoice: Object
});

const form = useForm({
    customer_id: props.editingInvoice?.customer_id || '',
    issue_date: props.editingInvoice?.issue_date || new Date().toISOString().split('T')[0],
    due_date: props.editingInvoice?.due_date || new Date(Date.now() + 7 * 24 * 60 * 60 * 1000).toISOString().split('T')[0],
    amount: props.editingInvoice?.amount || 0,
    tax: props.editingInvoice?.tax || 0,
    status: props.editingInvoice?.status || 'draft',
    notes: props.editingInvoice?.notes || ''
});

const searchQuery = ref('');
const isEditing = ref(!!props.editingInvoice);

const totalAmount = computed(() => {
    return (parseFloat(form.amount) + parseFloat(form.tax)).toFixed(2);
});

const submit = () => {
    if (isEditing.value) {
        form.put(route('invoices.update', props.editingInvoice.id));
    } else {
        form.post(route('invoices.store'));
    }
};

const editInvoice = (invoice) => {
    router.visit(route('invoices.index', { edit: invoice.id }));
};

const cancelEdit = () => {
    router.visit(route('invoices.index'));
};

const deleteInvoice = (id) => {
    if (confirm('Are you sure you want to delete this invoice?')) {
        router.delete(route('invoices.destroy', id));
    }
};

const sendInvoice = (id) => {
    if (confirm('Send this invoice to the customer?')) {
        router.post(route('invoices.send', id));
    }
};

const statusClasses = {
    draft: 'bg-gray-100 text-gray-800',
    sent: 'bg-blue-100 text-blue-800',
    paid: 'bg-green-100 text-green-800',
    overdue: 'bg-yellow-100 text-yellow-800',
    cancelled: 'bg-red-100 text-red-800'
};
</script>

<template>
    <Head title="Invoices" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800">Invoice Management</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <!-- Invoice Form -->
                        <div class="mb-8 p-4 border rounded-lg">
                            <h3 class="text-lg font-medium mb-4">
                                {{ isEditing ? 'Edit Invoice' : 'Create New Invoice' }}
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
                                        <label class="block text-sm font-medium text-gray-700">Issue Date *</label>
                                        <input
                                            v-model="form.issue_date"
                                            type="date"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"
                                            required
                                        >
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Due Date *</label>
                                        <input
                                            v-model="form.due_date"
                                            type="date"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"
                                            required
                                        >
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
                                        <label class="block text-sm font-medium text-gray-700">Tax *</label>
                                        <input
                                            v-model="form.tax"
                                            type="number"
                                            min="0"
                                            step="0.01"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"
                                            required
                                        >
                                        <p v-if="form.errors.tax" class="mt-1 text-sm text-red-600">
                                            {{ form.errors.tax }}
                                        </p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Total Amount</label>
                                        <input
                                            :value="totalAmount"
                                            type="text"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 bg-gray-100"
                                            readonly
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
                                            <option value="paid">Paid</option>
                                            <option value="overdue">Overdue</option>
                                            <option value="cancelled">Cancelled</option>
                                        </select>
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Notes</label>
                                        <textarea
                                            v-model="form.notes"
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
                                        {{ isEditing ? 'Update' : 'Create' }} Invoice
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Invoice List -->
                        <div>
                            <input
                                v-model="searchQuery"
                                type="text"
                                placeholder="Search invoices..."
                                class="w-full mb-4 px-4 py-2 border rounded-lg"
                            >

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Invoice #</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Due Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr v-for="invoice in invoices" :key="invoice.id">
                                            <td class="px-6 py-4 whitespace-nowrap">{{ invoice.invoice_number }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ invoice.customer.name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">${{ invoice.total_amount.toLocaleString() }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ invoice.due_date }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    :class="statusClasses[invoice.status]"
                                                    class="px-2 py-1 text-xs font-semibold rounded-full"
                                                >
                                                    {{ invoice.status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                                <button
                                                    @click="editInvoice(invoice)"
                                                    class="text-blue-600 hover:text-blue-900"
                                                >
                                                    Edit
                                                </button>
                                                <button
                                                    v-if="invoice.status === 'draft'"
                                                    @click="sendInvoice(invoice.id)"
                                                    class="text-green-600 hover:text-green-900"
                                                >
                                                    Send
                                                </button>
                                                <button
                                                    @click="deleteInvoice(invoice.id)"
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
