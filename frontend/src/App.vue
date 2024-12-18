<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Navbar -->
    <Navbar
      @toggleFilter="toggleFilter"
      @toggleCart="toggleCart"
    />

    <div class="flex">
      <!-- Filter Panel -->
      <FilterPanel v-if="isFilterOpen" @close="toggleFilter" />

      <!-- Product List -->
      <main class="flex-1 p-6">
        <RouterView @addToCart="addItemToCart" />
      </main>
    </div>

    <!-- Cart Panel -->
    <CartPanel
      :isOpen="isCartOpen"
      :cartItems="cartItems"
      @close="toggleCart"
      @remove-item="removeItemFromCart"
    />
  </div>
</template>

<script>
import Navbar from './components/Navbar.vue';
import FilterPanel from './components/FilterPanel.vue';
import CartPanel from './components/CartPanel.vue';

export default {
  components: {
    Navbar,
    FilterPanel,
    CartPanel,
  },
  data() {
    return {
      isFilterOpen: false,
      isCartOpen: false,
      cartItems: [],
    };
  },
  methods: {
    toggleFilter() {
      this.isFilterOpen = !this.isFilterOpen;
    },
    toggleCart() {
      this.isCartOpen = !this.isCartOpen;
    },
    addItemToCart(product) {
      const existingItem = this.cartItems.find((item) => item.id === product.id);
      if (existingItem) {
        alert('Ez a termék már a kosárban van!');
      } else {
        this.cartItems.push(product);
        alert(`${product.name} hozzáadva a kosárhoz!`);
      }
    },
    removeItemFromCart(item) {
      const index = this.cartItems.findIndex((cartItem) => cartItem.id === item.id);
      if (index !== -1) {
        this.cartItems.splice(index, 1);
      }
    },
  },
};
</script>
