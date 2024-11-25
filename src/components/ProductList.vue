<template>
  <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
    <div
      v-for="product in products"
      :key="product.id"
      class="bg-white shadow-md rounded-lg overflow-hidden"
    >
      <img
        :src="product.image"
        alt="Product Image"
        class="h-48 w-full object-cover"
      />
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
</template>

<script>
export default {
  name: 'ProductList',
  data() {
    return {
      products: [
        { id: 1, name: 'Termék 1', price: 3000, image: 'https://via.placeholder.com/150' },
        { id: 2, name: 'Termék 2', price: 4500, image: 'https://via.placeholder.com/150' },
        { id: 3, name: 'Termék 3', price: 7000, image: 'https://via.placeholder.com/150' },
        { id: 4, name: 'Termék 4', price: 1200, image: 'https://via.placeholder.com/150' },
        { id: 5, name: 'Termék 5', price: 5000, image: 'https://via.placeholder.com/150' },
        { id: 6, name: 'Termék 6', price: 6000, image: 'https://via.placeholder.com/150' },
      ],
    };
  },
  methods: {
    addToCart(product) {
      this.$emit('addToCart', product);
    },
  },
};
</script>
