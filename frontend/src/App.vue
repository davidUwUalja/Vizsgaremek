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
import Navbar from './components/Navbar.vue';
import CartPanel from './components/CartPanel.vue';
import WishlistPanel from './components/WishlistPanel.vue';

export default {
  components: {
    Navbar,
    CartPanel,
    WishlistPanel
  },
  data() {
    return {
      isAuthenticated: false,
      isCartOpen: false,
      isWishlistOpen: false,
      cartItems: [],
      wishlistItems: []
    }
  },
  created() {
    this.loadStoredData();
  },
  methods: {
    loadStoredData() {
      const storedCart = localStorage.getItem('cartItems');
      if (storedCart) {
        this.cartItems = JSON.parse(storedCart);
      }
      
      const storedWishlist = localStorage.getItem('wishlist');
      if (storedWishlist) {
        this.wishlistItems = JSON.parse(storedWishlist);
      }
    },
    saveCart() {
      localStorage.setItem('cartItems', JSON.stringify(this.cartItems));
    },
    saveWishlist() {
      localStorage.setItem('wishlist', JSON.stringify(this.wishlistItems));
    },
    addToCart(item) {
      const existingItem = this.cartItems.find(i => i.id === item.id);
      
      if (existingItem) {
        existingItem.quantity = (existingItem.quantity || 1) + 1;
      } else {
        this.cartItems.push({ ...item, quantity: 1 });
      }
      
      this.saveCart();
      this.isCartOpen = true;
    },
    updateCartQuantity({ item, change }) {
      const index = this.cartItems.findIndex(i => i.id === item.id);
      if (index !== -1) {
        const newQuantity = (this.cartItems[index].quantity || 1) + change;
        
        if (newQuantity <= 0) {
          this.cartItems.splice(index, 1);
        } else {
          this.cartItems[index].quantity = newQuantity;
        }
        
        this.saveCart();
      }
    },
    removeFromCart(item) {
      this.cartItems = this.cartItems.filter(i => i.id !== item.id);
      this.saveCart();
    },
    addToWishlist(item) {
      const existingItem = this.wishlistItems.find(i => i.id === item.id);
      
      if (!existingItem) {
        this.wishlistItems.push(item);
        this.saveWishlist();
      }
      
      this.isWishlistOpen = true;
    },
    removeFromWishlist(item) {
      this.wishlistItems = this.wishlistItems.filter(i => i.id !== item.id);
      this.saveWishlist();
    },
    moveToCart(item) {
      this.addToCart(item);
      
      this.removeFromWishlist(item);
    },
    handleLogout() {
      this.isAuthenticated = false;
    },
    handleCheckout() {
      console.log('Processing checkout...');
    }
  }
}
</script>
