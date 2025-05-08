<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    customers: Array
});


</script>


<template>
  <Head title="Proposal" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
          Customers
        </h2>
        <Link :href="route('customers.create')" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
          Add Customer
        </Link>
      </div>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200">
            <!-- Table headers and rows -->
            <tbody>
              <tr v-for="customer in customers" :key="customer.id">
                <td class="px-6 py-4 whitespace-nowrap">
                  {{ customer.name }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  {{ customer.email }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <Link :href="route('customers.edit', customer.id)" class="text-blue-500 hover:text-blue-700">
                    Edit
                  </Link>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
