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
        <RouterView />
      </main>
    </div>

    <!-- Cart Panel -->
    <CartPanel
      :isOpen="isCartOpen"
      :cartItems="cartItems"
      @close="toggleCart"
    />
  </div>
</template>

<script>
import Navbar from './components/Navbar.vue';
import FilterPanel from './components/FilterPanel.vue';
import ProductList from './components/ProductList.vue';
import CartPanel from './components/CartPanel.vue';

export default {
  components: {
    Navbar,
    FilterPanel,
    ProductList,
    CartPanel,
  },
  data() {
    return {
      isFilterOpen: false,
      isCartOpen: false,
      cartItems: [
        { id: 1, name: 'Termék 1', price: 1000 },
        { id: 2, name: 'Termék 2', price: 2000 },
      ],
    };
  },
  methods: {
    toggleFilter() {
      this.isFilterOpen = !this.isFilterOpen;
    },
    toggleCart() {
      this.isCartOpen = !this.isCartOpen;
    },
  },
};
</script>
