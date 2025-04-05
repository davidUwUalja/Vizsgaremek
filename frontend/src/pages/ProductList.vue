<template>
  <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 p-6 bg-amber-50 min-h-screen">
    <div
      v-for="product in products"
      :key="product.id"
      class="bg-yellow-50 p-4 border-2 border-yellow-800 rounded-sm shadow-lg hover:shadow-2xl hover:border-yellow-900 transition-all duration-300 flex flex-col items-center text-center"
    >
      <!-- Termék képe -->
      <img 
        alt="Product Image" 
        class="w-full h-48 object-cover rounded-sm shadow-md filter sepia brightness-95 contrast-105 hover:scale-105 transition-transform duration-300" 
        :src="`data:image/jpeg;base64,${product.image_url}`" 
      />

      <!-- Név -->
      <h3 class="text-xl font-serif font-semibold text-yellow-800 mt-4 border-b-2 border-yellow-700 pb-1 w-full">
        {{ getLocalizedField(product, 'name') }}
      </h3>

      <!-- Anyag -->
      <p class="text-sm text-yellow-900 mt-1 italic">
        Anyag: {{ getLocalizedField(product, 'material') }}
      </p>

      <!-- Leírás (ha van) -->
      <p v-if="getLocalizedField(product, 'description')" class="text-sm text-yellow-800 mt-2">
        {{ getLocalizedField(product, 'description') }}
      </p>

      <!-- Kategória (ha van) -->
      <p v-if="getLocalizedField(product, 'category')" class="text-xs text-yellow-700 mt-1 font-mono">
        Kategória: {{ getLocalizedField(product, 'category') }}
      </p>

      <!-- Ár -->
      <p class="text-yellow-900 mt-2 font-serif font-semibold">
        Ár: {{ new Intl.NumberFormat(locale.value === 'hu' ? 'hu-HU' : 'en-US').format(getLocalizedField(product, 'price')) }} Ft
      </p>

      <!-- Gombok -->
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
import { useI18n } from 'vue-i18n';
import { http } from '@utils/http';

export default {
  name: 'ProductList',
  setup() {
    const products = ref([]);
    const { locale } = useI18n();

    const fetchProducts = async () => {
      try {
        const response = await http.get('http://backend.vm1.test/api/products');
        products.value = response.data.data;
      } catch (error) {
        console.error('Hiba a termékek betöltése során:', error);
      }
    };

    onMounted(fetchProducts);

    const addToCart = (product) => {
      console.log('Kosárhoz adva:', product);
    };

    /**
     * Visszaadja a lokalizált értéket a termékből.
     * Ha nem találja a kért nyelvi mezőt, az alapértelmezett magyar mezőt adja vissza.
     */
    const getLocalizedField = (product, field) => {
      // elvárva, hogy a termékobjektum property-jei pl. name_hu és name_en legyenek
      return product[`${field}_${locale.value}`] || product[`${field}_hu`];
    };

    return {
      products,
      addToCart,
      getLocalizedField,
      locale,
    };
  },
};
</script>
