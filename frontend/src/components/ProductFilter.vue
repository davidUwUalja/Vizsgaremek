<template>
  <div class="p-4 bg-gray-100 border rounded-md shadow-md dark:bg-gray-800 dark:border-gray-700">
    <h3 class="text-lg font-semibold mb-4 dark:text-gray-100">{{ $t('filterTitle') }}</h3>

    <!-- Category -->
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

    <!-- Material -->
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

    <!-- Price -->
    <div class="mb-4">
      <label for="priceRange" class="block text-sm font-medium dark:text-gray-300">
        {{ $t('priceRange') }}
      </label>
      <select id="priceRange" v-model="selected" @change="onRangeChange" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
        <option :value="null">--</option>
        <option v-for="r in priceRanges" :key="r.label" :value="r">{{ r.label }}</option>
      </select>
    </div>

    <!-- Apply -->
    <button
      @click="emitApply"
      class="w-full mt-2 px-4 py-2 bg-yellow-700 text-yellow-50 font-serif text-sm rounded-sm hover:bg-yellow-900 border border-yellow-800 shadow-md transition-all duration-300 dark:bg-yellow-600 dark:border-yellow-500 dark:text-gray-100"
    >
      {{ $t('applyFilters') }}
    </button>
  </div>
</template>

<script>
import { ref, computed } from 'vue';
import { useI18n } from 'vue-i18n';

export default {
  name: 'ProductFilter',
  props: {
    categories: { type: Array, required: true },
    materials: { type: Array, required: true }
  },
  emits: ['apply'],
  setup(props, { emit }) {
    const { locale } = useI18n();
    const local = ref({ categories: [], materials: [], minPrice: null, maxPrice: null });
    const selected = ref(null);

    const priceRanges = computed(() =>
      locale.value === 'hu'
        ? [
            { label: '1000 - 8000 Ft', min: 1000, max: 8000 },
            { label: '8001 - 15000 Ft', min: 8001, max: 15000 },
            { label: '15001 - 30000 Ft', min: 15001, max: 30000 },
            { label: '30001 - 200000 Ft', min: 30001, max: 200000 }
          ]
        : [
            { label: '$5 - $30', min: 5, max: 30 },
            { label: '$31 - $70', min: 31, max: 70 },
            { label: '$71 - $150', min: 71, max: 150 },
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
    };

    const emitApply = () => emit('apply', { ...local.value });

    return { local, selected, priceRanges, onRangeChange, emitApply };
  }
};
</script>