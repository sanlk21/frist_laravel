```vue
<template>
  <div class="container mx-auto p-6">
    <h1 class="text-4xl font-bold mb-4">Welcome to Your Application</h1>
    <p class="text-lg text-gray-600 mb-6">
      Manage your customers, invoices, and proposals with ease.
    </p>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <Link href="/customer" class="block p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
        <h2 class="text-xl font-semibold mb-2">Customers</h2>
        <p class="text-gray-600">View and manage your customer list.</p>
      </Link>
      <Link href="/invoice" class="block p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
        <h2 class="text-xl font-semibold mb-2">Invoices</h2>
        <p class="text-gray-600">Track and create invoices.</p>
      </Link>
      <Link href="/proposal" class="block p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
        <h2 class="text-xl font-semibold mb-2">Proposals</h2>
        <p class="text-gray-600">Manage your business proposals.</p>
      </Link>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';

export default {
  name: 'Welcome',
  components: { Link },
};
</script>

<style scoped>
</style>
```
