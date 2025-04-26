<template>
  <BaseLayout>
    <!-- Filter Toggle Button -->
    <button
      v-if="!showFilter"
      @click="toggleFilter"
      class="fixed top-28 left-4 z-50 px-3 py-2 bg-yellow-700 text-yellow-50 font-serif text-sm rounded-full hover:bg-yellow-900 border border-yellow-800 shadow-md transition-all duration-300"
    >
      <span class="material-icons text-lg">🛠️</span>
    </button>

    <!-- Filter Sidebar -->
    <div
      v-if="showFilter"
      class="absolute top-20 left-0 h-[calc(100%-5rem)] w-[300px] bg-white border-r-2 border-yellow-800 shadow-lg transition-transform duration-300 z-40 overflow-y-auto dark:bg-gray-900 dark:border-gray-700"
    >
      <div class="p-4 relative">
        <button
          @click="toggleFilter"
          class="absolute top-4 right-4 px-2 py-1 bg-yellow-700 text-yellow-50 text-sm rounded-full hover:bg-yellow-900 border border-yellow-800 shadow-md transition-all duration-300 dark:bg-yellow-600 dark:border-yellow-500 dark:text-gray-100"
        >
          ✖️
        </button>
        <h3 class="text-lg font-serif font-semibold text-yellow-800 mb-4 dark:text-yellow-300">
          🛠️ {{ $t('filterTitle') }}
        </h3>
        <ProductFilter
          :categories="availableCategories"
          :materials="availableMaterials"
          @apply="applyFilters"
        />
      </div>
    </div>

    <!-- Toasts -->
    <div class="fixed top-4 right-4 z-50 space-y-2">
      <div
        v-for="(toast, i) in toasts"
        :key="i"
        class="bg-green-100 border-l-4 border-green-700 text-green-800 p-4 shadow-lg rounded-sm flex items-center"
      >
        <div class="mr-2">✅</div>
        <div class="flex-1">{{ toast.message }}</div>
        <button @click="removeToast(i)" class="ml-4">✖️</button>
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
        class="relative bg-yellow-50 p-4 border-2 border-yellow-800 rounded-sm shadow-lg w-80 h-[550px] flex flex-col"
      >
        <!-- Image -->
        <img
          alt="Product Image"
          class="w-full h-48 object-cover rounded-sm shadow-md"
          :src="`data:image/jpeg;base64,${product.image_url}`"
        />
        <!-- Details -->
        <div class="mt-4 flex-grow overflow-hidden">
          <h3 class="text-xl font-serif font-semibold text-yellow-800 border-b-2 border-yellow-700 pb-1 w-full">
            🛒 {{ getLocalizedField(product, 'name') }}
          </h3>
          <p v-if="getLocalizedField(product, 'description')" class="text-sm text-yellow-800 mt-1 overflow-hidden">
            📝 {{ getLocalizedField(product, 'description') }}
          </p>
          <p class="text-yellow-900 font-serif font-semibold mt-2">
            
            💰 {{ $t('price') }}: {{ formatPrice(getLocalizedField(product, 'price')) }} {{ currency }}
          </p>
        </div>
        <!-- Buttons fixed 4px from edges -->
        <div class="absolute bottom-1 left-1 right-1 flex space-x-2 justify-center">
          <RouterLink
            :to="{name: 'ProductDetail', params:{id: product.id }}"
            class="flex-1 text-center px-2 py-1 bg-yellow-700 text-yellow-50 text-sm rounded-sm hover:bg-yellow-900"
          >
            🔍 {{ $t('viewDetails') }}
          </RouterLink>
          <button
            @click="handleAddToCart(product)"
            class="flex-1 text-center px-2 py-1 bg-yellow-700 text-yellow-50 text-sm rounded-sm hover:bg-yellow-900"
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
import ProductFilter from '@components/ProductFilter.vue';

export default {
  name: 'productList',
  components: { BaseLayout, ProductFilter },
  setup() {
    const productStore = useProductStore();
    const { locale } = useI18n();
    const products = computed(() => productStore.products);
    const toasts = ref([]);
    const filters = ref({ categories: [], materials: [], minPrice: null, maxPrice: null });

    const availableCategories = computed(() => {
      const cats = products.value.map(p => getLocalizedField(p, 'category'));
      return [...new Set(cats)];
    });
    const availableMaterials = computed(() => {
      const mats = products.value.map(p => getLocalizedField(p, 'material'));
      return [...new Set(mats)];
    });

    const getLocalizedField = (product, field) =>
      productStore.getLocalizedField(product, field, locale.value);
    const formatPrice = price =>
      new Intl.NumberFormat(locale.value === 'hu' ? 'hu-HU' : 'en-US').format(price);

    const filteredProducts = computed(() =>
      products.value.filter(p => {
        const cat = getLocalizedField(p, 'category');
        const mat = getLocalizedField(p, 'material');
        const matchCategory = !filters.value.categories.length || filters.value.categories.includes(cat);
        const matchMaterial = !filters.value.materials.length || filters.value.materials.includes(mat);
        const price = getLocalizedField(p, 'price');
        const matchPrice =
          (filters.value.minPrice == null || price >= filters.value.minPrice) &&
          (filters.value.maxPrice == null || price <= filters.value.maxPrice);
        return matchCategory && matchMaterial && matchPrice;
      })
    );

    const applyFilters = newFilters => { filters.value = { ...newFilters }; };
    const handleAddToCart = product => {
      productStore.addToCart(product);
      toasts.value.push({ message: `${getLocalizedField(product, 'name')} added to cart` });
      setTimeout(() => toasts.value.shift(), 3000);
    };
    const removeToast = idx => toasts.value.splice(idx, 1);

    const showFilter = ref(false);
    const toggleFilter = () => (showFilter.value = !showFilter.value);

    const windowWidth = ref(window.innerWidth);
    const updateWindowWidth = () => (windowWidth.value = window.innerWidth);
    onMounted(() => window.addEventListener('resize', updateWindowWidth));

    const gridClasses = computed(() => {
      if (windowWidth.value < (showFilter.value ? 1000 : 650)) return 'grid-cols-1';
      if (windowWidth.value < (showFilter.value ? 1330 : 1000)) return 'grid-cols-2';
      if (windowWidth.value < (showFilter.value ? 1600 : 1330)) return 'grid-cols-3';
      return showFilter.value ? 'grid-cols-4' : 'grid-cols-5';
    });
    const currency = computed(() => (locale.value === 'hu' ? 'Ft' : '$'));

    return {
      availableCategories,
      availableMaterials,
      filteredProducts,
      getLocalizedField,
      formatPrice,
      handleAddToCart,
      removeToast,
      applyFilters,
      toasts,
      showFilter,
      toggleFilter,
      gridClasses,
      currency,
      locale
    };
  }
};
</script>
<route lang="yaml">
  name: productList  
</route>