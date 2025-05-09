<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
  customer: {
    type: Object,
    default: () => ({
      name: '',
      email: '',
      phone: '',
      address: '',
      status: 'active'
    })
  },
  isEditing: Boolean
});

const form = useForm({
  name: props.customer.name,
  email: props.customer.email,
  phone: props.customer.phone,
  address: props.customer.address,
  status: props.customer.status
});
</script>

<template>
  <form @submit.prevent="isEditing
    ? form.put(route('customers.update', customer.id))
    : form.post(route('customers.store'))"
  >
    <div class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700">Name</label>
        <input
          v-model="form.name"
          type="text"
          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
          required
        >
        <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
      </div>

      <!-- Add other fields similarly -->

      <div class="flex justify-end">
        <button
          type="submit"
          class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 disabled:opacity-50"
          :disabled="form.processing"
        >
          {{ isEditing ? 'Update' : 'Create' }} Customer
        </button>
      </div>
    </div>
  </form>
</template>
