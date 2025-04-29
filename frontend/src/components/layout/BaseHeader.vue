<template>
  <div>
    <Navbar 
      :isAuthenticated="isAuthenticated" 
      @logout="handleLogout" 
      @toggleCart="isCartOpen = !isCartOpen"
      @toggleWishlist="isWishlistOpen = !isWishlistOpen"
    />
    <CartPanel 
      :isOpen="isCartOpen" 
      :items="cartItems"
      @close="isCartOpen = false"
      @update-quantity="updateCartQuantity"
      @remove-item="removeFromCart"
      @checkout="handleCheckout"
    />
    
    <WishlistPanel
      :isOpen="isWishlistOpen"
      :items="wishlistItems"
      @close="isWishlistOpen = false"
      @move-to-cart="moveToCart"
      @remove-item="removeFromWishlist"
    />
    
    <CartCheckout 
      v-if="isCheckoutOpen"
      :totalPrice="calculateTotalPrice()"
      @close="isCheckoutOpen = false"
      @confirm-payment="processPayment"
    />
  </div>
</template>

<script>
import Navbar from '@components/Navbar.vue';
import CartPanel from '@components/CartPanel.vue';
import WishlistPanel from '@components/WishlistPanel.vue';
import CartCheckout from '@/components/CartCheckout.vue'; 
import { useProductStore } from '@stores/ProductDatasStore';
import AuthModal from '@/components/AuthModal.vue';
import { useUserStore } from '@/stores/UserDatasStore.mjs';

export default {
  components: { 
    AuthModal,
    CartPanel,
    CartCheckout, 
    Navbar,
    WishlistPanel,
  },
  data() {
    return {
      isLanguageMenuOpen: false,
      isProfileMenuOpen:  false,
      isModalOpen:        false,
      isMobileMenuOpen:   false,
      searchQuery:        '',
      isCartOpen: false,
      isWishlistOpen: false,
      isCheckoutOpen: false, 
      wishlistItems: [],
    }
  },
  computed: {
    cartItems() {
      return useProductStore().cartItems;
    },
    isAuthenticated() {
      return !!this.userStore.user;
    },
    userStore() {
      return useUserStore()
    },
    userRole() {
      return this.userStore.user?.role || null
    },
    isAdmin() {
      return this.userRole === 'admin'
    },
    settingsRoute() {
      return this.isAdmin
        ? { name: 'adminSettings' }
        : { name: 'settings' }
    },
  },
  created() {
    // Csak wishlist/cart töltés maradjon!
    const storedWishlist = localStorage.getItem("wishlist");
    if (storedWishlist) {
      this.wishlistItems = JSON.parse(storedWishlist);
    }
    const productStore = useProductStore();
    const storedCartItems = localStorage.getItem('cartItems');
    if (storedCartItems && productStore.cartItems.length === 0) {
      productStore.cartItems = JSON.parse(storedCartItems);
    }
  },
  methods: {
    toggleLanguageMenu() {
      this.isLanguageMenuOpen = !this.isLanguageMenuOpen
    },
    toggleProfileMenu() {
      this.isProfileMenuOpen = !this.isProfileMenuOpen
    },
    toggleMobileMenu() {
      this.isMobileMenuOpen = !this.isMobileMenuOpen
    },
    performSearch() {
      console.log('Keresés:', this.searchQuery)
    },
    changeLanguage(lang) {
      this.$i18n.locale = lang
      this.isLanguageMenuOpen = false
    },
    openModal() {
      this.isModalOpen = true
    },
    closeModal() {
      this.isModalOpen = false
    },
    handleLogout() {
      localStorage.removeItem('token')
      this.userStore.$reset()
      this.$router.push({ name: 'login' })
    },
    addToWishlist(item) {
      const existingItem = this.wishlistItems.find((i) => i.id === item.id);
      if (!existingItem) {
        this.wishlistItems.push(item);
        localStorage.setItem("wishlist", JSON.stringify(this.wishlistItems));
      }
      this.isWishlistOpen = true;
    },
    removeFromWishlist(item) {
      this.wishlistItems = this.wishlistItems.filter((i) => i.id !== item.id);
      localStorage.setItem("wishlist", JSON.stringify(this.wishlistItems));
    },
    moveToCart(item) {
      const productStore = useProductStore();
      productStore.addToCart(item);
      this.removeFromWishlist(item);
    },
    updateCartQuantity({ item, change }) {
      const productStore = useProductStore();
      productStore.updateCartQuantity({ item, change });
    },
    removeFromCart(item) {
      const productStore = useProductStore();
      productStore.removeFromCart(item);
    },
    handleCheckout() {
      console.log("Processing checkout...");
      this.isCartOpen = false; 
      this.isCheckoutOpen = true; 
    },
    
    calculateTotalPrice() {
      return this.cartItems.reduce((total, item) => {
        const price = item[`price_${this.$i18n.locale}`] || item.price_hu;
        return total + (price * (item.quantity || 1));
      }, 0);
    },
    
    processPayment() {
      alert('Payment processed successfully!');
      
      const productStore = useProductStore();
      productStore.clearCart();
      
      this.isCheckoutOpen = false;
    }
  },
}
</script>
