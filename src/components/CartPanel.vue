<template>
  <div
    v-if="isOpen"
    class="fixed top-0 right-0 w-1/3 h-full bg-white shadow-lg p-6 z-50"
  >
    <h2 class="text-xl font-bold mb-4">Kosár</h2>
    <ul>
      <li
        v-for="item in cartItems"
        :key="item.id"
        class="flex justify-between items-center mb-4"
      >
        <span>{{ item.name }}</span>
        <span>{{ item.price }} Ft</span>
      </li>
    </ul>
    <button
      @click="$emit('close')"
      class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
    >
      Bezár
    </button>
  </div>
</template>

<script>
export default {
  name: 'CartPanel',
  props: {
    isOpen: Boolean,
    cartItems: Array,
  },
};
</script>
