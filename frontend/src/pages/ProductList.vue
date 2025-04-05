<template>
  <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 p-6 bg-amber-50 min-h-screen">
    <div
      v-for="product in products"
      :key="product.id"
      class="bg-yellow-50 p-4 border-2 border-yellow-800 rounded-sm shadow-lg hover:shadow-2xl hover:border-yellow-900 transition-all duration-300 flex flex-col items-center text-center"
    >
      <img 
        alt="Product Image" 
        class="w-full h-48 object-cover rounded-sm shadow-md filter sepia brightness-95 contrast-105 hover:scale-105 transition-transform duration-300" 
        src="../images/minijurtakesajandekok.jpg" 
      />
      <h3 class="text-xl font-serif font-semibold text-yellow-800 mt-4 border-b-2 border-yellow-700 pb-1 w-full">
        {{ product.name }}
      </h3>
      <p class="text-yellow-900 mt-2 font-serif">
        Ár: {{ product.price }} {{ currency }}
      </p>
      <div class="flex space-x-2 mt-4 w-full justify-center">
        <router-link
          :to="`/products/${product.id}`"
          class="px-4 py-2 bg-yellow-700 text-yellow-50 font-serif text-sm rounded-sm hover:bg-yellow-900 border border-yellow-800 shadow-md transition-all duration-300"
        >
          Megtekintés
        </router-link>
        <button
          @click="addToCart(product)"
          class="px-4 py-2 bg-yellow-700 text-yellow-50 font-serif text-sm rounded-sm hover:bg-yellow-900 border border-yellow-800 shadow-md transition-all duration-300"
        >
          Kosárba
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import {http} from '@utils/http';

export default {
  name: 'ProductList',
  setup() {
    const products = ref([]);
    const locale = ref(document.documentElement.lang || 'hu');
    const currency = ref(locale.value === 'hu' ? 'Ft' : '$'); 

    const fetchProducts = async () => {
      try {
        const response = await http.get('http://backend.vm1.test/api/products');
        products.value = response.data.data.map((product) => ({
          id: product.id,
          name: locale.value === 'hu' ? product.name_hu : product.name_en,
          price: locale.value === 'hu' ? product.price_hu : product.price_en,
        }));
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
      currency,
    };
  },
};
</script>