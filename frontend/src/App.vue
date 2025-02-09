<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Navbar -->
    <Navbar @toggleCart="toggleCart" @toggleFilter="toggleFilter" @loginpage="showModal" />

    <!-- Modal for Login/Register -->
    <Modal :isOpen="isModalOpen" @close="closeModal">
      <div class="flex justify-center mb-4">
        <button
          @click="activeComponent = 'Login'"
          :class="{ 'bg-blue-500 text-white': activeComponent === 'Login', 'text-blue-500 hover:underline': activeComponent !== 'Login' }"
          class="p-2 rounded mr-2"
        >
          Bejelentkezés
        </button>
        <button
          @click="activeComponent = 'Register'"
          :class="{ 'bg-blue-500 text-white': activeComponent === 'Register', 'text-blue-500 hover:underline': activeComponent !== 'Register' }"
          class="p-2 rounded"
        >
          Regisztráció
        </button>
      </div>
      <component
        :is="activeComponent"
        @success="handleAuthSuccess"
        @switch="switchComponent"
      />
    </Modal>

    <!-- Sidebar Filter Panel -->
    <FilterPanel 
      v-if="isFilterOpen" 
      class="fixed left-0 top-0 h-full w-1/4 bg-white shadow-md z-10 transition-transform duration-300"
      @close="toggleFilter"
    />

    <!-- Wishlist Panel -->
    <Wishlist 
        v-if="isWishlistOpen"
        :wishlist="wishlist"
        @add-to-cart="addToCart"
        @remove-from-wishlist="removeFromWishlist"
    />

    <!-- Cart Panel -->
    <CartPanel
      :isOpen="isCartOpen"
      :cartItems="cartItems"
      @close="toggleCart"
      @remove-item="removeItemFromCart"
    />

    <!-- Main Content -->
    <router-view />

    <!-- Footer -->
    <Footer />
  </div>
</template>

---

<script>
import Modal from "./components/Modal.vue";
import Login from "./components/Login.vue";
import Register from "./components/Register.vue";
import Navbar from "./components/Navbar.vue";
import CartPanel from "./components/CartPanel.vue";
import Footer from "./components/Footer.vue";
import FilterPanel from "./components/FilterPanel.vue";

export default {
  components: { Modal, Login, Register, Navbar, CartPanel, Footer, FilterPanel },
  data() {
    return {
      isModalOpen: false,
      isCartOpen: false,
      isFilterOpen: false, // Tracks the filter panel's visibility
      activeComponent: "Login",
      cartItems: [
        { id: 1, name: "Termék 1", price: 1000, quantity: 2 },
        { id: 2, name: "Termék 2", price: 1500, quantity: 1 },
      ],
    };
  },
  methods: {
    showModal() {
      this.isModalOpen = true;
    },
    closeModal() {
      this.isModalOpen = false;
    },
    toggleCart() {
      this.isCartOpen = !this.isCartOpen;
    },
    toggleFilter() {
      this.isFilterOpen = !this.isFilterOpen;
    },
    removeItemFromCart(item) {
      const index = this.cartItems.findIndex((cartItem) => cartItem.id === item.id);
      if (index !== -1) {
        this.cartItems.splice(index, 1);
      }
    },
    handleAuthSuccess() {
      this.closeModal();
    },
  },
};
</script>
