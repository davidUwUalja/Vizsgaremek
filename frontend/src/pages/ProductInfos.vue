<template>
  <div class="min-h-screen bg-gray-100 p-6 flex items-center justify-center">
    <div v-if="!product" class="text-gray-500 text-center">Adatok betöltése...</div>
    <div v-else class="bg-white shadow-md rounded-lg p-6 flex max-w-4xl w-full">
      <!-- Bal oldali kép -->
      <div class="w-1/2 pr-4">
        <img
          v-if="product.image_url"
          :src="product.image_url"
          alt="Product Image"
          class="w-full h-auto object-cover rounded-lg"
        />
        <div v-else class="bg-gray-200 w-full h-48 rounded-lg flex items-center justify-center">
          <span class="text-gray-500">Nincs kép</span>
        </div>
      </div>
      <!-- Jobb oldali információ -->
      <div class="w-1/2">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">{{ product.name }}</h1>
        <p class="text-lg text-gray-600 mb-2">Anyag: {{ product.material }}</p>
        <p class="text-gray-700 mb-4">Leírás: {{ product.description }}</p>
        <p class="text-lg text-gray-600 mb-2">Ár: {{ product.price }} Ft</p>
        <p class="text-gray-700 mb-4">Elérhető mennyiség: {{ product.stock }}</p>
        <p class="text-gray-700 mb-6">Kategória: {{ product.category }}</p>
        <button
          @click="addToCart(product)"
          class="px-6 py-3 bg-green-500 text-white font-medium rounded hover:bg-green-600"
        >
          Kosárba
        </button>
      </div>
    </div>
  </div>
</template>

  
  <script>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import { useRoute } from 'vue-router';
  
  export default {
    name: 'ProductInfos',
    setup() {
      const route = useRoute();
      const product = ref(null);
      const fetchProduct = async () => {
        try {
          const response = await axios.get(`http://backend.vm1.test/api/products/${route.params.id}`);
          product.value = response.data.data; // Ha a válasz a `data` kulcsban csomagolt.
        } catch (error) {
          console.error('Hiba a termék adatainak betöltése során:', error);
        }
      };

  
      onMounted(fetchProduct);
  
      const addToCart = (product) => {
        console.log('Kosárhoz adva:', product);
      };
  
      return {
        product,
        addToCart,
      };
    },
  };
  </script>