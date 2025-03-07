<template>
    <div class="fixed right-0 top-0 h-full w-80 bg-white shadow-lg z-40 transform transition-transform duration-300" :class="{'translate-x-0': isOpen, 'translate-x-full': !isOpen}">
      <div class="p-4 flex flex-col h-full">
        <div class="flex justify-between items-center pb-4 border-b">
          <h2 class="text-xl font-semibold">{{ $t('wishlist') || 'Wishlist' }}</h2>
          <button @click="$emit('close')" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>
        
        <div class="flex-grow overflow-y-auto py-4">
          <div v-if="items.length === 0" class="text-gray-500 text-center py-8">
            {{ $t('ures') || 'A kivánságlista ures.' }}
          </div>
          <div v-else class="space-y-4">
            <div v-for="item in items" :key="item.id" class="flex flex-col border-b pb-4">
              <div class="flex justify-between">
                <p class="font-medium">{{ item.name }}</p>
                <p class="text-gray-600">{{ item.price }} Ft</p>
              </div>
              <div class="flex space-x-2 mt-2">
                <button @click="moveToCart(item)" class="flex-1 bg-blue-500 text-white px-2 py-1 rounded text-sm hover:bg-blue-600">
                  {{ $t('addToCart') || 'Add to Cart' }}
                </button>
                <button @click="removeItem(item)" class="flex-1 bg-red-500 text-white px-2 py-1 rounded text-sm hover:bg-red-600">
                  {{ $t('remove') || 'Remove' }}
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