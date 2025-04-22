<template>
  <BaseLayout>
    <!-- Filter Toggle Button -->
    <button
      @click="toggleFilter"
      class="fixed top-4 left-4 z-50 px-4 py-2 bg-yellow-700 text-yellow-50 font-serif text-sm rounded-sm hover:bg-yellow-900 border border-yellow-800 shadow-md transition-all duration-300"
    >
      {{ showFilter ? $t('hideFilter') : $t('showFilter') }}
    </button>

    <!-- Filter Sidebar -->
    <div
      class="fixed top-0 left-0 h-full bg-yellow-50 border-r-2 border-yellow-800 shadow-lg transition-transform duration-300 z-40"
      :class="{ '-translate-x-full': !showFilter, 'translate-x-0': showFilter }"
      style="width: 300px;"
    >
      <div class="p-4">
        <h3 class="text-lg font-serif font-semibold text-yellow-800 mb-4">
          {{ $t('filterTitle') }}
        </h3>
        <ProductFilter
          :categories="availableCategories"
          :onFilterChange="applyFilters"
        />
      </div>
    </div>

    <!-- Toast notification stack -->
    <div class="fixed top-4 right-4 z-50 space-y-2">
      <div
        v-for="(toast, index) in toasts"
        :key="index"
        class="bg-green-100 border-l-4 border-green-700 text-green-800 p-4 shadow-lg rounded-sm flex items-center transition-all duration-300"
      >
        <div class="flex-shrink-0 mr-2">
          ✓
        </div>
        <div class="flex-1">
          {{ toast.message }}
        </div>
        <button @click="removeToast(index)" class="ml-4 text-green-800 hover:text-green-900">
          ✕
        </button>
      </div>
    </div>

    <!-- Product Grid -->
    <div
      class="grid gap-6 p-3 bg-amber-50 min-h-screen justify-items-center"
      :class="{
        'grid-cols-1 sm:grid-cols-2 md:grid-cols-3': windowWidth < 1100,
        'lg:grid-cols-4 xl:grid-cols-5': windowWidth >= 1100,
      }"
    >
      <div
        v-for="product in filteredProducts"
        :key="product.id"
        class="bg-yellow-50 p-4 border-2 border-yellow-800 rounded-sm shadow-lg hover:shadow-2xl hover:border-yellow-900 transition-all duration-300 flex flex-col items-center text-center w-80"
      >
        <!-- Product Image -->
        <img
          alt="Product Image"
          class="w-full h-48 object-cover rounded-sm shadow-md brightness-95 contrast-105 hover:scale-105 transition-transform duration-300"
          :src="`data:image/jpeg;base64,${product.image_url}`"
        />

        <!-- Product Name -->
        <h3 class="text-xl font-serif font-semibold text-yellow-800 mt-4 border-b-2 border-yellow-700 pb-1 w-full">
          {{ getLocalizedField(product, 'name') }}
        </h3>

        <!-- Material -->
        <p class="text-sm text-yellow-900 mt-1 italic">
          {{ $t('material') }}: {{ getLocalizedField(product, 'material') }}
        </p>

        <!-- Description -->
        <p v-if="getLocalizedField(product, 'description')" class="text-sm text-yellow-800 mt-2">
          {{ getLocalizedField(product, 'description') }}
        </p>

        <!-- Category -->
        <p v-if="getLocalizedField(product, 'category')" class="text-xs text-yellow-700 mt-1 font-mono">
          {{ $t('category') }}: {{ getLocalizedField(product, 'category') }}
        </p>

        <!-- Price -->
        <p class="text-yellow-900 mt-2 font-serif font-semibold">
          {{ $t('price') }}:
          {{ new Intl.NumberFormat(locale.value === 'hu' ? 'hu-HU' : 'en-US').format(getLocalizedField(product, 'price')) }} {{ locale.value === 'hu' ? 'Ft' : '$' }}
        </p>

        <!-- Buttons -->
        <div class="flex space-x-2 mt-4 w-full justify-center">
          <router-link
            :to="`/products/${product.id}`"
            class="px-4 py-2 bg-yellow-700 text-yellow-50 font-serif text-sm rounded-sm hover:bg-yellow-900 border border-yellow-800 shadow-md transition-all duration-300"
          >
            {{ $t('viewDetails') }}
          </router-link>
          <button
            @click="handleAddToCart(product)"
            class="px-4 py-2 bg-yellow-700 text-yellow-50 font-serif text-sm rounded-sm hover:bg-yellow-900 border border-yellow-800 shadow-md transition-all duration-300"
          >
            {{ $t('addToCart') }}
          </button>
        </div>
      </div>
    </div>
  </BaseLayout>
</template>

<script>
import { computed, ref, onMounted } from 'vue';
import { useI18n } from 'vue-i18n';
import { useProductStore } from '@stores/ProductDatasStore';
import BaseLayout from '@layouts/BaseLayout.vue';
import ProductFilter from '@/components/ProductFilter.vue';

export default {
  name: 'ProductList',
  components: { BaseLayout, ProductFilter },
  setup() {
    const productStore = useProductStore();
    const { locale, t } = useI18n();

    const products = computed(() => productStore.products);
    const toasts = ref([]);
    const filters = ref({
      category: '',
      minPrice: null,
      maxPrice: null,
    });

    const availableCategories = computed(() =>
      [...new Set(products.value.map((product) => product.category))]
    );

    const getLocalizedField = (product, field) => {
      return productStore.getLocalizedField(product, field, locale.value);
    };

    const filteredProducts = computed(() => {
      return products.value.filter((product) => {
        const categoryMatch =
          !filters.value.category ||
          getLocalizedField(product, 'category') === filters.value.category;

        const price = getLocalizedField(product, 'price');
        const priceMatch =
          (!filters.value.minPrice || price >= filters.value.minPrice) &&
          (!filters.value.maxPrice || price <= filters.value.maxPrice);

        return categoryMatch && priceMatch;
      });
    });

    const applyFilters = (newFilters) => {
      filters.value = newFilters;
    };

    const handleAddToCart = (product) => {
      productStore.addToCart(product);

      // Create a new toast message
      const message = `${getLocalizedField(product, 'name')} - Kosárba helyezve`;
      const toast = { message };

      // Push it to the list
      toasts.value.push(toast);

      // Remove it after 3 seconds
      setTimeout(() => {
        const index = toasts.value.indexOf(toast);
        if (index !== -1) {
          toasts.value.splice(index, 1);
        }
      }, 3000);
    };

    const removeToast = (index) => {
      toasts.value.splice(index, 1);
    };

    const showFilter = ref(false);
    const toggleFilter = () => {
      showFilter.value = !showFilter.value;
    };

    const windowWidth = ref(window.innerWidth);
    const updateWindowWidth = () => {
      windowWidth.value = window.innerWidth;
    };

    onMounted(() => {
      window.addEventListener('resize', updateWindowWidth);
    });

    return {
      products,
      filteredProducts,
      availableCategories,
      getLocalizedField,
      handleAddToCart,
      locale,
      toasts,
      removeToast,
      applyFilters,
      showFilter,
      toggleFilter,
      windowWidth,
    };
  },
};
</script>

<route lang="json">
{
  "name": "productList",
  "meta": {
    "title": "Termékek listája"
  }
}
</route>
