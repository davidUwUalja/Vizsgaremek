
<template>
  <BaseLayout>
    <!-- Filter Toggle Button -->
    <button
      v-if="!showFilter"
      @click="toggleFilter"
      class="fixed top-28 left-4 z-50 px-3 py-2 bg-yellow-700 text-yellow-50
             font-serif text-sm rounded-full hover:bg-yellow-900 border
             border-yellow-800 shadow-md transition-all duration-300 flex items-center justify-center">
      <span class="material-icons text-lg">🛠️</span>
    </button>

    <!-- Filter Sidebar -->
    <div
      v-if="showFilter"
      class="absolute top-20 left-0 h-[calc(100%-5rem)] w-[300px] bg-yellow-50 border-r-2 border-yellow-800 shadow-lg
             transition-transform duration-300 z-40 overflow-y-auto"
    >
      <div class="p-4 relative">
        <button
          @click="toggleFilter"
          class="absolute top-4 right-4 px-2 py-1 bg-yellow-700 text-yellow-50 text-sm rounded-full
                 hover:bg-yellow-900 border border-yellow-800 shadow-md transition-all duration-300">
          ✖️
        </button>
        <h3 class="text-lg font-serif font-semibold text-yellow-800 mb-4">
          🛠️ {{ $t('filterTitle') }}
        </h3>
        <ProductFilter
          :categories="availableCategories"
          @filterChanged="applyFilters"
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
        <div class="flex-shrink-0 mr-2">✅</div>
        <div class="flex-1">{{ toast.message }}</div>
        <button @click="removeToast(index)" class="ml-4 text-green-800 hover:text-green-900">✖️</button>
      </div>
    </div>

    <!-- Product Grid -->
    <div
      class="grid gap-6 p-3 bg-amber-50 min-h-screen justify-items-center"
      :class="gridClasses"
      :style="{ marginLeft: showFilter ? '300px' : '0' }"
    >
      <div
        v-for="product in filteredProducts"
        :key="product.id"
        class="bg-yellow-50 p-4 border-2 border-yellow-800 rounded-sm shadow-lg hover:shadow-2xl hover:border-yellow-900
               transition-all duration-300 flex flex-col items-center text-center w-80"
      >
        <!-- Product Image -->
        <img
          alt="Product Image"
          class="w-full h-48 object-cover rounded-sm shadow-md brightness-95 contrast-105 hover:scale-105 transition-transform duration-300"
          :src="`data:image/jpeg;base64,${product.image_url}`"
        />

        <!-- Product Name -->
        <h3 class="text-xl font-serif font-semibold text-yellow-800 mt-4 border-b-2 border-yellow-700 pb-1 w-full">
          🛒 {{ getLocalizedField(product, 'name') }}
        </h3>

        <!-- Material -->
        <p class="text-sm text-yellow-900 mt-1 italic">
          🧵 {{ $t('material') }}: {{ getLocalizedField(product, 'material') }}
        </p>

        <!-- Description -->
        <p v-if="getLocalizedField(product, 'description')" class="text-sm text-yellow-800 mt-2">
          📝 {{ getLocalizedField(product, 'description') }}
        </p>

        <!-- Category -->
        <p v-if="getLocalizedField(product, 'category')" class="text-xs text-yellow-700 mt-1 font-mono">
          📂 {{ $t('category') }}: {{ getLocalizedField(product, 'category') }}
        </p>

        <!-- Price -->
        <p class="text-yellow-900 mt-2 font-serif font-semibold">
          💰 {{ $t('price') }}:
          {{ new Intl.NumberFormat(locale === 'hu' ? 'hu-HU' : 'en-US').format(getLocalizedField(product, 'price')) }}
          {{ currency }}
        </p>

        <!-- Buttons -->
        <div class="flex space-x-2 mt-4 w-full justify-center">
          <router-link
            :to="`/products/${product.id}`"
            class="px-4 py-2 bg-yellow-700 text-yellow-50 font-serif text-sm rounded-sm hover:bg-yellow-900
                   border border-yellow-800 shadow-md transition-all duration-300"
          >
            🔍 {{ $t('viewDetails') }}
          </router-link>
          <button
            @click="handleAddToCart(product)"
            class="px-4 py-2 bg-yellow-700 text-yellow-50 font-serif text-sm rounded-sm hover:bg-yellow-900
                   border border-yellow-800 shadow-md transition-all duration-300"
          >
            ➕ {{ $t('addToCart') }}
          </button>
        </div>
      </div>
    </div>
  </BaseLayout>
</template>

<script>
import { ref, computed, onMounted } from 'vue';
import { useI18n } from 'vue-i18n';
import { useProductStore } from '@stores/ProductDatasStore';
import BaseLayout from '@layouts/BaseLayout.vue';
import ProductFilter from '@/components/ProductFilter.vue';

export default {
  name: 'productList',
  components: { BaseLayout, ProductFilter },
  setup() {
    const productStore = useProductStore();
    const { locale, t } = useI18n();

    const products = computed(() => productStore.products);
    const toasts = ref([]);
    const filters = ref({ category: '', minPrice: null, maxPrice: null });

    const availableCategories = computed(() =>
      [...new Set(products.value.map(p => p.category))]
    );

    const getLocalizedField = (product, field) =>
      productStore.getLocalizedField(product, field, locale.value);

    const filteredProducts = computed(() =>
      products.value.filter(p => {
        const categoryMatch = !filters.value.category ||
          getLocalizedField(p, 'category') === filters.value.category;
        const price = getLocalizedField(p, 'price');
        const priceMatch = (!filters.value.minPrice || price >= filters.value.minPrice) &&
                           (!filters.value.maxPrice || price <= filters.value.maxPrice);
        return categoryMatch && priceMatch;
      })
    );

    const applyFilters = newFilters => {
      filters.value = { ...newFilters };
    };

    const handleAddToCart = product => {
      productStore.addToCart(product);
      const message = `${getLocalizedField(product, 'name')} - Kosárba helyezve`;
      const toast = { message };
      toasts.value.push(toast);
      setTimeout(() => {
        const idx = toasts.value.indexOf(toast);
        if (idx !== -1) toasts.value.splice(idx, 1);
      }, 3000);
    };

    const removeToast = idx => {
      toasts.value.splice(idx, 1);
    };

    const showFilter = ref(false);
    const toggleFilter = () => { showFilter.value = !showFilter.value; };

    const windowWidth = ref(window.innerWidth);
    const updateWindowWidth = () => { windowWidth.value = window.innerWidth; };

    const gridClasses = computed(() => {
      let cols;
      if (windowWidth.value < (showFilter.value ? 1000 : 650)) cols = 'grid-cols-1';
      else if (windowWidth.value < (showFilter.value ? 1330 : 1000)) cols = 'grid-cols-2';
      else if (windowWidth.value < (showFilter.value ? 1600 : 1330)) cols = 'grid-cols-3';
      else if (windowWidth.value < 1600) cols = 'grid-cols-4';
      else cols = showFilter.value ? 'grid-cols-4' : 'grid-cols-5';
      return cols;
    });

    onMounted(() => window.addEventListener('resize', updateWindowWidth));

    const currency = computed(() => locale.value === 'hu' ? 'Ft' : '$');

    return {
      availableCategories,
      filteredProducts,
      getLocalizedField,
      handleAddToCart,
      removeToast,
      applyFilters,
      toasts,
      showFilter,
      toggleFilter,
      gridClasses,
      locale: locale.value,
      currency,
      t
    };
  }
};
</script>