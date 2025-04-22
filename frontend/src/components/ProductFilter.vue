<template>
  <div class="p-4 bg-gray-100 border rounded-md shadow-md">
    <h3 class="text-lg font-semibold mb-4">{{ $t('Szűrő') }}</h3>

    <!-- Category Filter -->
    <div class="mb-4">
      <label for="category" class="block text-sm font-medium text-gray-700">
        {{ $t('category') }}
      </label>
      <select
        id="category"
        v-model="filters.category"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500"
      >
        <option value="">{{ $t('allCategories') }}</option>
        <option
          v-for="category in localizedCategories"
          :key="category"
          :value="category"
        >
          {{ category }}
        </option>
      </select>
    </div>

    <!-- Price Filter -->
    <div>
      <label for="price" class="block text-sm font-medium text-gray-700">
        {{ $t('priceRange') }}
      </label>
      <div class="flex space-x-2 mt-1">
        <input
          type="number"
          v-model.number="filters.minPrice"
          placeholder="{{ $t('minPrice') }}"
          class="w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500"
        />
        <input
          type="number"
          v-model.number="filters.maxPrice"
          placeholder="{{ $t('maxPrice') }}"
          class="w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500"
        />
      </div>
    </div>
  </div>
</template>

<script>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';

export default {
  name: 'ProductFilter',
  props: {
    categories: {
      type: Array,
      required: true,
    },
    onFilterChange: {
      type: Function,
      required: true,
    },
  },
  setup(props) {
    const { locale, t } = useI18n();

    const filters = {
      category: '',
      minPrice: null,
      maxPrice: null,
    };

    const localizedCategories = computed(() =>
      props.categories.map((category) =>
        t(`categories.${category}`)
      )
    );

    const updateFilters = () => {
      props.onFilterChange(filters);
    };

    return {
      filters,
      localizedCategories,
      updateFilters,
      t,
    };
  },
  watch: {
    filters: {
      handler: 'updateFilters',
      deep: true,
    },
  },
};
</script>