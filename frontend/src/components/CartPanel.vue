<template>
  <div class="fixed right-0 top-0 h-full w-80 bg-white shadow-lg z-40 transform transition-transform duration-300" :class="{'translate-x-0': isOpen, 'translate-x-full': !isOpen}">
    <div class="p-4 flex flex-col h-full">
      <div class="flex justify-between items-center pb-4 border-b">
        <h2 class="text-xl font-semibold">{{ $t('cart') }}</h2>
        <button @click="$emit('close')" class="text-gray-500 hover:text-gray-700">✕</button>
      </div>
      
      <div class="flex-grow overflow-y-auto py-4">
        <div v-if="items.length === 0" class="text-gray-500 text-center py-8">
          {{ $t('ures') }}
        </div>
        <div v-else class="space-y-4">
          <div v-for="item in items" :key="item.id" class="flex justify-between items-center border-b pb-2">
            <div>
              <p class="font-medium">{{ item.name }}</p>
              <p class="text-gray-600">{{ item.price }} Ft</p>
            </div>
            <div class="flex items-center">
              <button @click="updateQuantity(item, -1)" class="px-2 bg-gray-200 rounded-l">-</button>
              <span class="px-3 bg-gray-100">{{ item.quantity }}</span>
              <button @click="updateQuantity(item, 1)" class="px-2 bg-gray-200 rounded-r">+</button>
              <button @click="removeItem(item)" class="ml-2 text-red-500">🗑️</button>
            </div>
          </div>
        </div>
      </div>
      
      <div class="pt-4 border-t">
        <div class="flex justify-between mb-4">
          <span class="font-semibold">{{ $t('total') }}:</span>
          <span class="font-bold">{{ totalPrice }} Ft</span>
        </div>
        <button @click="checkout" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
          {{ $t('checkout') }}
        </button>
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
  computed: {
    totalPrice() {
      return this.items.reduce((total, item) => total + (item.price * (item.quantity || 1)), 0);
    }
  },
  methods: {
    updateQuantity(item, change) {
      this.$emit('update-quantity', { item, change });
    },
    removeItem(item) {
      this.$emit('remove-item', item);
    },
    checkout() {
      // Handle checkout logic
      this.$emit('checkout');
    }
  }
}
</script>