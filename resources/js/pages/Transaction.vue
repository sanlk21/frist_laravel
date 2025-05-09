<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    transactions: Array,
    invoices: Array,
    customers: Array,
    editingTransaction: Object
});

const form = useForm({
    invoice_id: props.editingTransaction?.invoice_id || '',
    customer_id: props.editingTransaction?.customer_id || '',
    amount: props.editingTransaction?.amount || 0,
    payment_method: props.editingTransaction?.payment_method || 'credit_card',
    status: props.editingTransaction?.status || 'pending',
    notes: props.editingTransaction?.notes || ''
});

const searchQuery = ref('');
const isEditing = ref(!!props.editingTransaction);

const submit = () => {
    if (isEditing.value) {
        form.put(route('transactions.update', props.editingTransaction.id));
    } else {
        form.post(route('transactions.store'));
    }
};

const editTransaction = (transaction) => {
    router.visit(route('transactions.index', { edit: transaction.id }));
};

const cancelEdit = () => {
    router.visit(route('transactions.index'));
};

const deleteTransaction = (id) => {
    if (confirm('Are you sure you want to delete this transaction?')) {
        router.delete(route('transactions.destroy', id));
    }
};

const statusClasses = {
    pending: 'bg-yellow-100 text-yellow-800',
    completed: 'bg-green-100 text-green-800',
    failed: 'bg-red-100 text-red-800',
    refunded: 'bg-blue-100 text-blue-800'
};

const paymentMethodIcons = {
    credit_card: '💳',
    paypal: '🔵',
    bank_transfer: '🏦',
    cash: '💵'
};

const filteredInvoices = computed(() => {
    if (!form.customer_id) return props.invoices;
    return props.invoices.filter(invoice => invoice.customer_id == form.customer_id);
});

const updateInvoiceAmount = () => {
    if (form.invoice_id) {
        const selectedInvoice = props.invoices.find(i => i.id == form.invoice_id);
        if (selectedInvoice) {
            form.amount = selectedInvoice.total_amount - selectedInvoice.paid_amount;
        }
    }
};
</script>

<template>
    <Head title="Transactions" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800">Transaction Management</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <!-- Transaction Form -->
                        <div class="mb-8 p-4 border rounded-lg">
                            <h3 class="text-lg font-medium mb-4">
                                {{ isEditing ? 'Edit Transaction' : 'Record New Transaction' }}
                            </h3>

                            <form @submit.prevent="submit">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Customer *</label>
                                        <select
                                            v-model="form.customer_id"
                                            @change="form.invoice_id = ''"
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
                                        <label class="block text-sm font-medium text-gray-700">Invoice *</label>
                                        <select
                                            v-model="form.invoice_id"
                                            @change="updateInvoiceAmount"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"
                                            required
                                            :disabled="!form.customer_id"
                                        >
                                            <option value="">Select Invoice</option>
                                            <option
                                                v-for="invoice in filteredInvoices"
                                                :key="invoice.id"
                                                :value="invoice.id"
                                            >
                                                {{ invoice.invoice_number }} - ${{ invoice.total_amount }} (Due: {{ invoice.due_date }})
                                            </option>
                                        </select>
                                        <p v-if="form.errors.invoice_id" class="mt-1 text-sm text-red-600">
                                            {{ form.errors.invoice_id }}
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
                                        <label class="block text-sm font-medium text-gray-700">Payment Method *</label>
                                        <select
                                            v-model="form.payment_method"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"
                                            required
                                        >
                                            <option value="credit_card">Credit Card</option>
                                            <option value="paypal">PayPal</option>
                                            <option value="bank_transfer">Bank Transfer</option>
                                            <option value="cash">Cash</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Status *</label>
                                        <select
                                            v-model="form.status"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"
                                            required
                                        >
                                            <option value="pending">Pending</option>
                                            <option value="completed">Completed</option>
                                            <option value="failed">Failed</option>
                                            <option value="refunded">Refunded</option>
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
                                        {{ isEditing ? 'Update' : 'Record' }} Transaction
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Transaction List -->
                        <div>
                            <input
                                v-model="searchQuery"
                                type="text"
                                placeholder="Search transactions..."
                                class="w-full mb-4 px-4 py-2 border rounded-lg"
                            >

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">TXN ID</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Invoice</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Method</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr v-for="transaction in transactions" :key="transaction.id">
                                            <td class="px-6 py-4 whitespace-nowrap">{{ transaction.transaction_id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ transaction.invoice.invoice_number }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ transaction.customer.name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">${{ transaction.amount.toLocaleString() }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="mr-1">{{ paymentMethodIcons[transaction.payment_method] }}</span>
                                                {{ transaction.payment_method.replace('_', ' ') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    :class="statusClasses[transaction.status]"
                                                    class="px-2 py-1 text-xs font-semibold rounded-full"
                                                >
                                                    {{ transaction.status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ transaction.created_at }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                                <button
                                                    @click="editTransaction(transaction)"
                                                    class="text-blue-600 hover:text-blue-900"
                                                >
                                                    Edit
                                                </button>
                                                <button
                                                    @click="deleteTransaction(transaction.id)"
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
