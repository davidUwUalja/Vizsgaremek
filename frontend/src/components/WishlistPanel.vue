<template>
  <div
    class="fixed right-0 top-0 h-full w-80 bg-yellow-50 shadow-xl z-40 transform transition-transform duration-300 border-l-4 border-yellow-800"
    :class="{ 'translate-x-0': isOpen, 'translate-x-full': !isOpen }"
  >
    <div class="p-4 flex flex-col h-full font-serif text-yellow-900">
      <!-- Header -->
      <div class="flex justify-between items-center pb-4 border-b-2 border-yellow-700">
        <h2 class="text-2xl font-bold text-yellow-800 tracking-wide">
          {{ $t('wishlist') || 'Wishlist' }}
        </h2>
        <button
          @click="$emit('close')"
          class="text-yellow-700 hover:text-yellow-900 transition-colors duration-200 text-xl"
        >
          ✕
        </button>
      </div>

      <!-- Wishlist Items -->
      <div class="flex-grow overflow-y-auto py-4">
        <div v-if="items.length === 0" class="text-center text-yellow-700 italic py-12">
          {{ $t('ures') || 'A kívánságlista üres.' }}
        </div>
        <div v-else class="space-y-4">
          <div
            v-for="item in items"
            :key="item.id"
            class="p-4 bg-white border-2 border-yellow-800 rounded-sm shadow-md hover:shadow-lg transition-shadow duration-300"
          >
            <div class="flex justify-between items-center mb-2">
              <p class="font-semibold text-yellow-800">{{ item.name }}</p>
              <p class="text-yellow-700">{{ item.price }} Ft</p>
            </div>
            <div class="flex space-x-2">
              <button
                @click="moveToCart(item)"
                class="flex-1 px-3 py-2 bg-yellow-700 text-yellow-50 text-sm rounded-sm hover:bg-yellow-900 transition-colors duration-300 border border-yellow-800 shadow"
              >
                {{ $t('addToCart') || 'Kosárba' }}
              </button>
              <button
                @click="removeItem(item)"
                class="flex-1 px-3 py-2 bg-red-600 text-white text-sm rounded-sm hover:bg-red-700 transition-colors duration-300 border border-red-800 shadow"
              >
                {{ $t('remove') || 'Eltávolítás' }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

  <script>
  export default {
    props: {
      isOpen: Boolean,
      items: {
        type: Array,
        default: () => []
      }
    },
    methods: {
      moveToCart(item) {
        this.$emit('move-to-cart', item);
      },
      removeItem(item) {
        this.$emit('remove-item', item);
      }
    }
  }
  </script>