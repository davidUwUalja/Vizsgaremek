<template>
  <transition name="slide-in">
    <div
      v-if="isOpen"
      class="fixed right-0 top-0 h-full w-1/3 bg-white shadow-lg p-4 overflow-y-auto"
    >
      <h2 class="text-lg font-bold mb-4">Kosár</h2>
      <ul class="divide-y divide-gray-300">
        <li
          v-for="item in cartItems"
          :key="item.id"
          class="flex justify-between items-center py-4"
        >
          <div>
            <h3 class="font-semibold">{{ item.name }}</h3>
            <p class="text-gray-500">{{ item.price }} Ft</p>
          </div>
          <button
            @click="$emit('remove-item', item)"
            class="text-red-500 hover:text-red-700"
          >
            Törlés
          </button>
        </li>
      </ul>
      <div class="mt-4">
        <p class="text-lg font-semibold">
          Összesen: {{ totalPrice }} Ft
        </p>
        <button
          class="mt-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600"
        >
          Tovább a fizetéshez
        </button>
      </div>
      <button
        @click="$emit('close')"
        class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
      >
        Bezárás
      </button>
    </div>
  </transition>
</template>

<script>
export default {
  name: "CartPanel",
  props: {
    isOpen: {
      type: Boolean,
      required: true,
    },
    cartItems: {
      type: Array,
      required: true,
    },
  },
  computed: {
    totalPrice() {
      return this.cartItems.reduce((sum, item) => sum + item.price, 0);
    },
  },
};
</script>
