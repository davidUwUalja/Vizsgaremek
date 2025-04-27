<template>
  <div
    class="fixed right-0 top-0 h-full w-80 bg-yellow-50 shadow-xl z-40 transform transition-transform duration-300 border-l-4 border-yellow-800"
    :class="{ 'translate-x-0': isOpen, 'translate-x-full': !isOpen }"
  >
    <div class="p-4 flex flex-col h-full font-serif text-yellow-900">
      <div class="flex justify-between items-center pb-4 border-b-2 border-yellow-700">
        <h2 class="text-2xl font-bold text-yellow-800 tracking-wide">
          {{ $t('cart') }}
        </h2>
        <button
          @click="$emit('close')"
          class="text-yellow-700 hover:text-yellow-900 transition-colors duration-200 text-xl"
        >
          ✕
        </button>
      </div>

      <div class="flex-grow overflow-y-auto py-4">
        <div v-if="items.length === 0" class="text-center text-yellow-700 italic py-12">
          {{ $t('empty') }}
        </div>
        <div v-else class="space-y-4">
          <div
            v-for="item in items"
            :key="item.id"
            class="p-4 bg-white border-2 border-yellow-800 rounded-sm shadow-md hover:shadow-lg transition-shadow duration-300"
          >
            <div class="flex justify-between mb-2">
              <div>
                <p class="font-semibold text-yellow-800">{{ getLocalizedField(item, 'name') }}</p>
                <p class="text-yellow-700">
                  {{ getLocalizedField(item, 'price') * item.quantity }} {{ currencySymbol }}
                </p>
              </div>
              <button
                @click="removeItem(item)"
                class="text-red-600 hover:text-red-800 text-xl ml-2 transition-colors duration-200"
              >
                🗑️
              </button>
            </div>
            <div class="flex items-center justify-end space-x-1">
              <button
                @click="updateQuantity(item, -1)"
                class="px-3 py-1 bg-yellow-200 text-yellow-800 rounded-l hover:bg-yellow-300 transition"
              >
                −
              </button>
              <span class="px-4 py-1 bg-yellow-100 text-yellow-900 border border-yellow-700 rounded-sm">
                {{ item.quantity }}
              </span>
              <button
                @click="updateQuantity(item, 1)"
                class="px-3 py-1 bg-yellow-200 text-yellow-800 rounded-r hover:bg-yellow-300 transition"
              >
                +
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="pt-4 border-t-2 border-yellow-700">
        <div class="flex justify-between mb-4 text-lg font-semibold text-yellow-800">
          <span>{{ $t('total') }}:</span>
          <span class="font-bold">
            {{ totalPrice }} {{ currencySymbol }}
          </span>
        </div>
        <button
          @click="checkout"
          class="w-full px-4 py-3 bg-yellow-700 text-yellow-50 font-serif font-semibold rounded-sm border-2 border-yellow-800 hover:bg-yellow-900 transition-all duration-300 shadow-md hover:shadow-xl"
          :disabled="items.length === 0"
        >
          {{ $t('checkout') }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { useI18n } from 'vue-i18n';

export default {
  props: {
    isOpen: Boolean,
    items: {
      type: Array,
      default: () => []
    }
  },
  setup() {
    const { locale } = useI18n();
    const getLocalizedField = (item, field) => {
      return item[`${field}_${locale.value}`] || item[`${field}_hu`];
    };

    return {
      locale,
      getLocalizedField
    };
  },
  computed: {
    totalPrice() {
      return this.items.reduce((total, item) => total + (this.getLocalizedField(item, 'price') * (item.quantity || 1)), 0);
    },
    currencySymbol() {
      return this.$i18n.locale === 'hu' ? 'Ft' : '$';
    }
  },
  methods: {
    updateQuantity(item, change) {
      if (item.quantity + change > 0) {
        this.$emit('update-quantity', { item, change });
      }
    },
    removeItem(item) {
      this.$emit('remove-item', item);
    },
    checkout() {
      if (this.items.length > 0) {
        this.$emit('checkout');
      }
    }
  }
};
</script>