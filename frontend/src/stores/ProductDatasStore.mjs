import { defineStore } from "pinia";
import { http } from "@utils/http.mjs";

export const useProductStore = defineStore("product", {
  state: () => ({
    products: [],
    cartItems: [],
    wishlistItems: []
  }),
  actions: {
    async fetchProducts() {
      try {
        const response = await http.get('http://backend.vm1.test/api/products');
        this.products = response.data.data;
      } catch (error) {
        console.error('Hiba a termékek betöltése során:', error);
      }
    },
    addToCart(product) {
      const existingItem = this.cartItems.find(item => item.id === product.id);
      if (existingItem) {
        existingItem.quantity += 1;
      } else {
        this.cartItems.push({ ...product, quantity: 1 });
      }
      localStorage.setItem('cartItems', JSON.stringify(this.cartItems));
    },
    updateCartQuantity({ item, change }) {
      const cartItem = this.cartItems.find(cartItem => cartItem.id === item.id);
      if (cartItem) {
        cartItem.quantity += change;
        if (cartItem.quantity <= 0) {
          this.cartItems = this.cartItems.filter(cartItem => cartItem.id !== item.id);
        }
        localStorage.setItem('cartItems', JSON.stringify(this.cartItems));
      }
    },
    removeFromCart(item) {
      this.cartItems = this.cartItems.filter(cartItem => cartItem.id !== item.id);
      localStorage.setItem('cartItems', JSON.stringify(this.cartItems));
    },
    clearCart() {
      this.cartItems = [];
      localStorage.setItem('cartItems', JSON.stringify([]));
    },
    // New wishlist actions
    addToWishlist(product) {
      const existingItem = this.wishlistItems.find(item => item.id === product.id);
      if (!existingItem) {
        this.wishlistItems.push({ ...product });
        localStorage.setItem('wishlist', JSON.stringify(this.wishlistItems));
      }
    },
    removeFromWishlist(item) {
      this.wishlistItems = this.wishlistItems.filter(wishlistItem => wishlistItem.id !== item.id);
      localStorage.setItem('wishlist', JSON.stringify(this.wishlistItems));
    },
    moveToCart(item) {
      this.addToCart(item);
      this.removeFromWishlist(item);
    },
    // Initialize store from localStorage
    initializeFromStorage() {
      const storedCartItems = localStorage.getItem('cartItems');
      if (storedCartItems) {
        this.cartItems = JSON.parse(storedCartItems);
      }
      
      const storedWishlist = localStorage.getItem('wishlist');
      if (storedWishlist) {
        this.wishlistItems = JSON.parse(storedWishlist);
      }
    }
  },
  getters: {
    getLocalizedField: () => {
      return (product, field, locale) => {
        return product[`${field}_${locale}`] || product[`${field}_hu`];
      };
    }
  }
});