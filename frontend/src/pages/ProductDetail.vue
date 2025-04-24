<template>
    <BaseLayout>
      <div class="max-w-4xl mx-auto mt-10 p-6 bg-yellow-50 border-2 border-yellow-800 rounded-sm shadow-lg flex flex-col md:flex-row">
        <!-- Termék kép -->
        <img
          alt="Product Image"
          class="w-full md:w-1/2 h-auto object-cover rounded-sm shadow-md"
          :src="`data:image/jpeg;base64,${product.image_url}`"
        />
        <!-- Termék adatok -->
        <div class="mt-4 md:mt-0 md:ml-6 flex flex-col justify-between">
          <div>
            <h2 class="text-2xl font-serif font-semibold text-yellow-800">
              🛒 {{ getLocalizedField(product, 'name') }}
            </h2>
            <p v-if="getLocalizedField(product, 'description')" class="mt-2 text-yellow-800">
              📝 {{ getLocalizedField(product, 'description') }}
            </p>
            <p v-if="getLocalizedField(product, 'material')" class="mt-2 text-yellow-800">
              🧵 {{ $t('material') }}: {{ getLocalizedField(product, 'material') }}
            </p>
            <p v-if="getLocalizedField(product, 'category')" class="mt-2 text-yellow-800">
              📂 {{ $t('category') }}: {{ getLocalizedField(product, 'category') }}
            </p>
            <p class="mt-2 text-yellow-900 font-serif font-semibold">
              💰 {{ $t('price') }}: {{ formatPrice(getLocalizedField(product, 'price')) }} {{ currency }}
            </p>
          </div>
          <button
            @click="handleAddToCart(product)"
            class="mt-4 md:mt-0 px-4 py-2 bg-yellow-700 text-yellow-50 text-sm rounded-sm hover:bg-yellow-900"
          >
            ➕ {{ $t('addToCart') }}
          </button>
        </div>
      </div>
    </BaseLayout>
  </template>
  
  <script>
  import { computed } from 'vue';
  import { useRoute } from 'vue-router';
  import { useI18n } from 'vue-i18n';
  import { useProductStore } from '@stores/ProductDatasStore';
  import BaseLayout from '@layouts/BaseLayout.vue';
  
  export default {
    name: 'ProductDetail',
    components: { BaseLayout },
    setup() {
      const route = useRoute();
      const productStore = useProductStore();
      const { locale } = useI18n();
      const productId = Number(route.params.id);
      const product = computed(() =>
        productStore.products.find(p => p.id === productId) || {}
      );
      const getLocalizedField = (product, field) =>
        productStore.getLocalizedField(product, field, locale.value);
      const formatPrice = price =>
        new Intl.NumberFormat(locale.value === 'hu' ? 'hu-HU' : 'en-US').format(price);
      const currency = computed(() => (locale.value === 'hu' ? 'Ft' : '$'));
      const handleAddToCart = prod => {
        productStore.addToCart(prod);
      };
  
      return {
        product,
        getLocalizedField,
        formatPrice,
        currency,
        handleAddToCart
      };
    }
  };
  </script>

  <route lang="yaml">
    name: ProductDetail
    
  </route>
