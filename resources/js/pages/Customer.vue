```vue
<template>
  <div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Customers</h1>
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer ID</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="customer in customers" :key="customer.id">
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ customer.id }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ customer.name }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ customer.email }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ customer.phone }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
              <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>
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
  name: 'Customer',
  data() {
    return {
      customers: [
        { id: 'CUST-001', name: 'John Doe', email: 'john@example.com', phone: '555-0101' },
        { id: 'CUST-002', name: 'Jane Smith', email: 'jane@example.com', phone: '555-0102' },
        { id: 'CUST-003', name: 'Acme Corp', email: 'contact@acme.com', phone: '555-0103' },
      ],
    };
  },
};
</script>

<style scoped>
</style>
```
