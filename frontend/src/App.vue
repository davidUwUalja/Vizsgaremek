<template>
  <div>
    <Navbar 
      :isAuthenticated="isAuthenticated" 
      @logout="handleLogout" 
      @toggleCart="isCartOpen = !isCartOpen"
      @toggleWishlist="isWishlistOpen = !isWishlistOpen"
    />
    
    <router-view 
      @add-to-cart="addToCart" 
      @add-to-wishlist="addToWishlist"
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
  </div>
</template>

<script>
import Navbar from '@components/Navbar.vue';
import CartPanel from '@components/CartPanel.vue';
import WishlistPanel from '@components/WishlistPanel.vue';
import { useProductStore } from '@stores/ProductDatasStore';
import { useUserStore } from '@stores/UserDatasStore';

export default {
  async mounted() {
    await useProductStore().fetchProducts();
  },
  components: {
    Navbar,
    CartPanel,
    WishlistPanel,
  },
  computed: {
    cartItems() {
      return useProductStore().cartItems;
    },
  },
  data() {
    return {
      isAuthenticated: !!localStorage.getItem("token"),
      isCartOpen: false,
      isWishlistOpen: false,
      wishlistItems: [],
    };
  },
  created() {
    const userStore = useUserStore();
    const token = localStorage.getItem("token");

    if (token) {
      userStore.fetchUser(); // Felhasználói adatok betöltése
    } else {
      userStore.logout(); // Ha nincs token, törölje az adatokat
    }

    const storedWishlist = localStorage.getItem("wishlist");
    if (storedWishlist) {
      this.wishlistItems = JSON.parse(storedWishlist);
    }
  },
  methods: {
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
    handleLogout() {
      const userStore = useUserStore();
      userStore.logout(); // Felhasználói adatok törlése
      this.isAuthenticated = false;
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
    },
  },
};
</script>
