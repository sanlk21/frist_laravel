```vue
<template>
  <div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Invoices</h1>

    <!-- Invoice Table -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice ID</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="invoice in invoices" :key="invoice.id">
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ invoice.id }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ invoice.customer }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ invoice.amount }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ invoice.date }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm">
              <span :class="{
                'px-2 py-1 text-xs font-semibold rounded-full': true,
                'bg-green-100 text-green-800': invoice.status === 'Paid',
                'bg-yellow-100 text-yellow-800': invoice.status === 'Pending',
                'bg-red-100 text-red-800': invoice.status === 'Overdue'
              }">
                {{ invoice.status }}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
              <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-4">View</a>
              <a href="#" class="text-red-600 hover:text-red-900">Delete</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Invoice',
  data() {
    return {
      // Sample invoice data (replace with props or API call)
      invoices: [
        { id: 'INV-001', customer: 'John Doe', amount: '$500.00', date: '2025-05-01', status: 'Paid' },
        { id: 'INV-002', customer: 'Jane Smith', amount: '$750.00', date: '2025-05-03', status: 'Pending' },
        { id: 'INV-003', customer: 'Acme Corp', amount: '$1200.00', date: '2025-04-28', status: 'Overdue' },
      ],
    };
  },
};
</script>

<style scoped>
/* Add any component-specific styles here */
</style>
```
