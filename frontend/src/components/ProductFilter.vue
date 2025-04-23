// ProductFilter.vue
<template>
  <div class="p-4 bg-gray-100 border rounded-md shadow-md">
    <h3 class="text-lg font-semibold mb-4">{{ $t('filterTitle') }}</h3>

    <!-- Category Filter -->
    <div class="mb-4">
      <label for="category" class="block text-sm font-medium text-gray-700">{{ $t('category') }}</label>
      <select
        id="category"
        v-model="local.category"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500"
      >
        <option value="">{{ $t('allCategories') }}</option>
        <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
      </select>
    </div>

    <!-- Price Range Filter -->
    <div>
      <label for="priceRange" class="block text-sm font-medium text-gray-700">{{ $t('priceRange') }}</label>
      <select
        id="priceRange"
        v-model="selected"
        @change="onRangeChange"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500"
      >
        <option :value="null">--</option>
        <option v-for="r in priceRanges" :key="r.label" :value="r">{{ r.label }}</option>
      </select>
    </div>
  </div>
</template>

<script>
import { ref, watch, computed } from 'vue';
import { useI18n } from 'vue-i18n';

export default {
  name: 'ProductFilter',
  props: {
    categories: { type: Array, required: true }
  },
  emits: ['filterChanged'],
  setup(props, { emit }) {
    const { locale } = useI18n();
    const local = ref({ category: '', minPrice: null, maxPrice: null });
    const selected = ref(null);

    const priceRanges = computed(() =>
      locale.value === 'hu'
        ? [
            { label: '1000 - 5000 Ft', min: 1000, max: 5000 },
            { label: '5001 - 10000 Ft', min: 5001, max: 10000 },
            { label: '10001 - 30000 Ft', min: 10001, max: 30000 },
            { label: '30001 - 200000 Ft', min: 30001, max: 200000 }
          ]
        : [
            { label: '$5 - $20', min: 5, max: 20 },
            { label: '$21 - $50', min: 21, max: 50 },
            { label: '$51 - $150', min: 51, max: 150 },
            { label: '$151 - $1000', min: 151, max: 1000 }
          ]
    );

    const onRangeChange = () => {
      if (selected.value) {
        local.value.minPrice = selected.value.min;
        local.value.maxPrice = selected.value.max;
      } else {
        local.value.minPrice = null;
        local.value.maxPrice = null;
      }
      emit('filterChanged', { ...local.value });
    };

    watch(
      () => local.value.category,
      () => emit('filterChanged', { ...local.value })
    );

    return { local, selected, priceRanges, onRangeChange };
  }
};
</script>