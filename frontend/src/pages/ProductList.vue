<template>
  <div class="flex">
    <FilterPanel
      v-if="isFilterOpen"
      @close="toggleFilter"
      class="w-1/4 bg-white shadow-md p-4"
    />
    <div class="flex-1 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 p-4">
      <div
        v-for="product in products"
        :key="product.id"
        class="bg-white shadow-md rounded-lg overflow-hidden"
      >
        <img :src="product.image" alt="Product Image" class="h-48 w-full object-cover" />
        <div class="p-4">
          <h3 class="font-semibold text-lg">{{ product.name }}</h3>
          <p class="text-gray-500">{{ product.price }} Ft</p>
          <button
            @click="addToCart(product)"
            class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
          >
            Kosárba
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ProductList',
  data() {
    return {
      isFilterOpen: false,
      products: [
        { id: 1, name: 'Termék 1', price: 3000, image: 'https://via.placeholder.com/150' },
        { id: 2, name: 'Termék 2', price: 4500, image: 'https://via.placeholder.com/150' },
      ],
    };
  },
  methods: {
    toggleFilter() {
      this.isFilterOpen = !this.isFilterOpen;
    },
    addToCart(product) {
      this.$emit('addToCart', product);
    },
  },
};
</script>