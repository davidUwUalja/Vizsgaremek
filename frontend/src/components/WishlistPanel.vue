<template>
  <div
    class="fixed right-0 top-0 h-full w-80 bg-yellow-50 shadow-xl z-40 transform transition-transform duration-300 border-l-4 border-yellow-800"
    :class="{ 'translate-x-0': isOpen, 'translate-x-full': !isOpen }"
  >
    <div class="p-4 flex flex-col h-full font-serif text-yellow-900">
      
      <div class="flex justify-between items-center pb-4 border-b-2 border-yellow-700">
        <h2 class="text-2xl font-bold text-yellow-800 tracking-wide">
          {{ $t('wishlist')}}
        </h2>
        <button
          @click="$emit('close')"
          class="text-yellow-700 hover:text-yellow-900 transition-colors duration-200 text-xl"
        >
          ✕
        </button>
      </div>

      <div class="flex-grow overflow-y-auto py-4">
        <div v-if="wishlistItems.length === 0" class="text-center text-yellow-700 italic py-12">
          {{ $t('empty') || 'A kívánságlista üres.' }}
        </div>
        <div v-else class="space-y-4">
          <div
            v-for="item in wishlistItems"
            :key="item.id"
            class="p-4 bg-white border-2 border-yellow-800 rounded-sm shadow-md hover:shadow-lg transition-shadow duration-300"
          >
            <div class="flex justify-between items-center mb-2">
              <p class="font-semibold text-yellow-800">{{ getLocalizedField(item, 'name') }}</p>
              <p class="text-yellow-700">{{ formatPrice(getLocalizedField(item, 'price')) }} {{ currency }}</p>
            </div>
            <div class="flex space-x-2">
              <button
                @click="moveToCart(item)"
                class="flex-1 px-3 py-2 bg-yellow-700 text-yellow-50 text-sm rounded-sm hover:bg-yellow-900 transition-colors duration-300 border border-yellow-800 shadow"
              >
                {{ $t('addToCart')}}
              </button>
              <button
                @click="removeItem(item)"
                class="flex-1 px-3 py-2 bg-red-600 text-white text-sm rounded-sm hover:bg-red-700 transition-colors duration-300 border border-red-800 shadow"
              >
                {{ $t('remove')}}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { useProductStore } from '@stores/ProductDatasStore';

export default {
  props: {
    isOpen: Boolean
  },
  setup(props, { emit }) {
    const productStore = useProductStore();
    const { locale } = useI18n();
    
    const wishlistItems = computed(() => productStore.wishlistItems);
    
    const getLocalizedField = (item, field) => {
      return productStore.getLocalizedField(item, field, locale.value);
    };
    
    const formatPrice = price => {
      return new Intl.NumberFormat(locale.value === 'hu' ? 'hu-HU' : 'en-US').format(price);
    };
    
    const currency = computed(() => (locale.value === 'hu' ? 'Ft' : '$'));
    
    const moveToCart = (item) => {
      productStore.moveToCart(item);
    };
    
    const removeItem = (item) => {
      productStore.removeFromWishlist(item);
    };
    
    return {
      wishlistItems,
      getLocalizedField,
      formatPrice,
      currency,
      moveToCart,
      removeItem
    };
  }
}
</script>