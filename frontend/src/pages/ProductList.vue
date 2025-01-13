// ProductList.vue módosítás
<template>
  <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 p-4">
    <div
      v-for="product in products"
      :key="product.id"
      class="bg-white shadow-md rounded-lg overflow-hidden"
    >
      <div class="p-4">
        <h3 class="font-semibold text-lg text-gray-800">{{ product.name }}</h3>
        <p class="text-gray-500">Ár: {{ product.price }} Ft</p>
        <div class="flex space-x-2 mt-4">
          <router-link
            :to="`/products/${product.id}`"
            class="px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded hover:bg-blue-600"
          >
            Megtekintés
          </router-link>
          <button
            @click="addToCart(product)"
            class="px-4 py-2 bg-green-500 text-white text-sm font-medium rounded hover:bg-green-600"
          >
            Kosárba
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
  name: 'ProductList',
  setup() {
    const products = ref([]);

    const fetchProducts = async () => {
      try {
        const response = await axios.get('http://backend.vm1.test/api/products');
        products.value = response.data.map(({ id, name, price }) => ({ id, name, price }));
      } catch (error) {
        console.error('Hiba a termékek betöltése során:', error);
      }
    };

    onMounted(fetchProducts);

    const addToCart = (product) => {
      console.log('Kosárhoz adva:', product);
    };

    return {
      products,
      addToCart,
    };
  },
};
</script>