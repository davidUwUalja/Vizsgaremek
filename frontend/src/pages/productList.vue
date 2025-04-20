<template>


  <BaseLayout>
    <div class="grid gap-6 p-3 bg-amber-50 min-h-screen justify-items-center grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
    <div
      v-for="product in products"
      :key="product.id"
      class="bg-yellow-50 p-4 border-2 border-yellow-800 rounded-sm shadow-lg hover:shadow-2xl hover:border-yellow-900 transition-all duration-300 flex flex-col items-center text-center w-80"
    >
      <!-- Termék képe -->
      <img 
        alt="Product Image" 
        class="w-full h-48 object-cover rounded-sm shadow-md brightness-95 contrast-105 hover:scale-105 transition-transform duration-300" 
        :src="`data:image/jpeg;base64,${product.image_url}`" 
      />

      <!-- Név -->
      <h3 class="text-xl font-serif font-semibold text-yellow-800 mt-4 border-b-2 border-yellow-700 pb-1 w-full">
        {{ getLocalizedField(product, 'name') }}
      </h3>

      <!-- Anyag -->
      <p class="text-sm text-yellow-900 mt-1 italic">
        {{ $t('material') }}: {{ getLocalizedField(product, 'material') }}
      </p>

      <!-- Leírás (ha van) -->
      <p v-if="getLocalizedField(product, 'description')" class="text-sm text-yellow-800 mt-2">
        {{ getLocalizedField(product, 'description') }}
      </p>

      <!-- Kategória (ha van) -->
      <p v-if="getLocalizedField(product, 'category')" class="text-xs text-yellow-700 mt-1 font-mono">
        {{ $t('category') }}: {{ getLocalizedField(product, 'category') }}
      </p>

      <!-- Ár -->
      <p class="text-yellow-900 mt-2 font-serif font-semibold">
        {{ $t('price') }}: 
        {{ new Intl.NumberFormat(locale.value === 'hu' ? 'hu-HU' : 'en-US').format(getLocalizedField(product, 'price')) }} Ft
      </p>

      <!-- Gombok -->
      <div class="flex space-x-2 mt-4 w-full justify-center">
        <router-link
          :to="`/products/${product.id}`"
          class="px-4 py-2 bg-yellow-700 text-yellow-50 font-serif text-sm rounded-sm hover:bg-yellow-900 border border-yellow-800 shadow-md transition-all duration-300"
        >
        {{ $t('viewDetails') }}
        </router-link>
        <button
          @click="addToCart(product)"
          class="px-4 py-2 bg-yellow-700 text-yellow-50 font-serif text-sm rounded-sm hover:bg-yellow-900 border border-yellow-800 shadow-md transition-all duration-300"
        >
        {{ $t('addToCart') }}:
        </button>
      </div>
    </div>
  </div>
  </BaseLayout>
</template>

<script>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { useProductStore } from '@stores/ProductDatasStore';
import BaseLayout from '@layouts/BaseLayout.vue';

export default {
  name: 'ProductList',
  components:{BaseLayout},
  setup() {
    const productStore = useProductStore();
    const { locale } = useI18n();

    const products = computed(() => productStore.products);

    const getLocalizedField = (product, field) => {
      return productStore.getLocalizedField(product, field, locale.value);
    };

    const addToCart = (product) => {
      productStore.addToCart(product);
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
<route lang="json">
  {
      "name": "productList",
      "meta":{
          "title": "Termékek listája"
      }
  }
  </route>

