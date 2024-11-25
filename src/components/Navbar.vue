<template>
  <nav class="bg-white shadow-md p-4 flex items-center justify-between">
    <!-- Left: Filter Button -->
    <div class="flex items-center">
      <button
        @click="$emit('toggleFilter')"
        class="text-gray-700 hover:bg-gray-200 p-2 rounded-md"
      >
        Szűrő
      </button>
    </div>

    <!-- Center: Navigation Links -->
    <div class="flex space-x-4">
      <router-link to="/" class="text-gray-700 hover:text-blue-500">Főoldal</router-link>
      <router-link to="/products" class="text-gray-700 hover:text-blue-500">Termékek</router-link>
      <router-link to="/contact" class="text-gray-700 hover:text-blue-500">Kapcsolat</router-link>
    </div>

    <!-- Right: Search Bar and Cart -->
    <div class="flex items-center space-x-4">
      <input
        type="text"
        placeholder="Keresés..."
        class="border rounded-md p-2 text-gray-700"
      />
      <button
        @click="$emit('toggleCart')"
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
      >
        Kosár
      </button>
    </div>
  </nav>
</template>

<script>
export default {
  name: 'Navbar',
};
</script>
