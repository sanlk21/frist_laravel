<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
  customers: Array
});

const searchQuery = ref('');
</script>

<template>
  <Head title="Customers" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800">Customers</h2>
        <Link
          :href="route('customers.create')"
          class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
        >
          New Customer
        </Link>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6">
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Search customers..."
              class="w-full mb-4 px-4 py-2 border rounded-lg"
            >

            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="customer in customers" :key="customer.id">
                  <td class="px-6 py-4 whitespace-nowrap">{{ customer.name }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">{{ customer.email }}</td>
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
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <Link
                      :href="route('customers.edit', customer.id)"
                      class="text-blue-600 hover:text-blue-900 mr-3"
                    >
                      Edit
                    </Link>
                    <Link
                      :href="route('customers.destroy', customer.id)"
                      method="delete"
                      as="button"
                      class="text-red-600 hover:text-red-900"
                    >
                      Delete
                    </Link>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
