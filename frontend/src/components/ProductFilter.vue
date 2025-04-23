<template>
  <div class="p-4 bg-gray-100 border rounded-md shadow-md dark:bg-gray-800 dark:border-gray-700">
    <h3 class="text-lg font-semibold mb-4 dark:text-gray-100">{{ $t('filterTitle') }}</h3>

    <!-- Category Checkboxes -->
    <div class="mb-4">
      <p class="font-medium mb-2 dark:text-gray-200">{{ $t('category') }}</p>
      <div class="space-y-2">
        <label v-for="cat in categories" :key="cat" class="flex items-center dark:text-gray-200">
          <input
            type="checkbox"
            :value="cat"
            v-model="local.categories"
            class="mr-2 rounded focus:ring-yellow-500 dark:focus:ring-yellow-400"
          />
          <span>{{ cat }}</span>
        </label>
      </div>
    </div>

    <!-- Material Checkboxes -->
    <div class="mb-4">
      <p class="font-medium mb-2 dark:text-gray-200">{{ $t('material') }}</p>
      <div class="space-y-2">
        <label v-for="mat in materials" :key="mat" class="flex items-center dark:text-gray-200">
          <input
            type="checkbox"
            :value="mat"
            v-model="local.materials"
            class="mr-2 rounded focus:ring-yellow-500 dark:focus:ring-yellow-400"
          />
          <span>{{ mat }}</span>
        </label>
      </div>
    </div>

    <!-- Price Range -->
    <div>
      <label for="priceRange" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $t('priceRange') }}</label>
      <select
        id="priceRange"
        v-model="selected"
        @change="onRangeChange"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
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
    categories: { type: Array, required: true },
    materials: { type: Array, required: true }
  },
  emits: ['filterChanged'],
  setup(props, { emit }) {
    const { locale } = useI18n();

    const local = ref({ categories: [], materials: [], minPrice: null, maxPrice: null });
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

    watch(local, () => emit('filterChanged', { ...local.value }), { deep: true });

    return { local, selected, priceRanges };
  }
};
</script>