<template>
  <BaseLayout>
    <div class="max-w-4xl mx-auto mt-10 p-6  dark:bg-white bg-yellow-50 border-2 border-yellow-800 rounded-md shadow-lg flex flex-col md:flex-row">
      <!-- Product image -->
      <img
        alt="Product Image"
        class="w-full md:w-1/2 h-auto object-cover rounded-md shadow-md"
        :src="`data:image/jpeg;base64,${product.image_url}`"
      />

      <!-- Product details -->
      <div class="mt-6 md:mt-0 md:ml-8 flex flex-col justify-between w-full">
        <div>
          <h2 class="text-3xl font-serif font-bold text-yellow-800">
            🛒 {{ getLocalizedField(product, 'name') }}
          </h2>
          <p v-if="getLocalizedField(product, 'description')" class="mt-3 text-yellow-800 text-base">
            📝 {{ getLocalizedField(product, 'description') }}
          </p>
          <p v-if="getLocalizedField(product, 'material')" class="mt-2 text-yellow-800">
            🧵 {{ $t('material') }}: {{ getLocalizedField(product, 'material') }}
          </p>
          <p v-if="getLocalizedField(product, 'category')" class="mt-2 text-yellow-800">
            📂 {{ $t('category') }}: {{ getLocalizedField(product, 'category') }}
          </p>
          <p class="mt-4 text-yellow-900 font-serif text-lg font-semibold">
            💰 {{ $t('price') }}: {{ formatPrice(getLocalizedField(product, 'price')) }} {{ currency }}
          </p>
        </div>

        <!-- Buttons side-by-side -->
        <div class="flex flex-wrap gap-2 mt-6">
          <button
            @click="handleAddToCart(product)"
            class="flex-1 px-4 py-2 bg-yellow-700 text-yellow-50 text-sm rounded-sm hover:bg-yellow-900 transition"
          >
            ➕ {{ $t('addToCart') }}
          </button>
          <button
            @click="handleAddToWishlist(product)"
            class="flex-1 px-4 py-2 bg-yellow-700 text-yellow-50 text-sm rounded-sm hover:bg-yellow-900 transition"
          >
            ❤️ {{ $t('addToWishlist') }}
          </button>
        </div>
      </div>
    </div>

    <!-- Toast notifications -->
    <div v-for="(toast, index) in toasts" :key="index"
      class="fixed top-5 right-5 bg-yellow-800 text-yellow-50 p-2 mb-2 rounded-sm shadow-lg">
      {{ toast.message }}
    </div>
  </BaseLayout>
</template>

<script>
import { useProductStore } from '@stores/ProductDatasStore';
import BaseLayout from '@layouts/BaseLayout.vue';

export default {
  name: 'ProductDetail',
  components: { BaseLayout },
  data() {
    return {
      product: {},
      productStore: null,
      toasts: []
    };
  },
  computed: {
    currency() {
      return this.$i18n.locale === 'hu' ? 'Ft' : '$';
    }
  },
  methods: {
    getLocalizedField(product, field) {
      return this.productStore.getLocalizedField(product, field, this.$i18n.locale);
    },
    formatPrice(price) {
      return new Intl.NumberFormat(
        this.$i18n.locale === 'hu' ? 'hu-HU' : 'en-US'
      ).format(price);
    },
    handleAddToCart(prod) {
      this.productStore.addToCart(prod);
    },
    handleAddToWishlist(product) {
      this.productStore.addToWishlist(product);
      this.toasts.push({
        message: `${this.getLocalizedField(product, 'name')} ${this.$t('addedToWishlist') || 'added to wishlist'}`
      });
      setTimeout(() => this.toasts.shift(), 3000);
    }
  },
  created() {
    this.productStore = useProductStore();
    const productId = Number(this.$route.params.id);
    this.product = this.productStore.products.find(p => p.id === productId) || {};
  }
};
</script>

<route lang="yaml">
name: ProductDetail
</route>
