```vue
<template>
  <div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Proposals</h1>
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proposal ID</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="proposal in proposals" :key="proposal.id">
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ proposal.id }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ proposal.title }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ proposal.customer }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ proposal.date }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm">
              <span :class="{
                'px-2 py-1 text-xs font-semibold rounded-full': true,
                'bg-green-100 text-green-800': proposal.status === 'Accepted',
                'bg-yellow-100 text-yellow-800': proposal.status === 'Pending',
                'bg-red-100 text-red-800': proposal.status === 'Rejected'
              }">
                {{ proposal.status }}
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
  name: 'Proposal',
  data() {
    return {
      proposals: [
        { id: 'PROP-001', title: 'Website Redesign', customer: 'John Doe', date: '2025-05-01', status: 'Accepted' },
        { id: 'PROP-002', title: 'Marketing Campaign', customer: 'Jane Smith', date: '2025-05-03', status: 'Pending' },
        { id: 'PROP-003', title: 'Product Launch', customer: 'Acme Corp', date: '2025-04-28', status: 'Rejected' },
      ],
    };
  },
};
</script>

<style scoped>
</style>
```
