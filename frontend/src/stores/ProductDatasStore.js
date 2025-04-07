import { defineStore } from "pinia";
import { http } from "@utils/http.mjs";

export const useProductStore = defineStore("product", {
  state: () => ({
    products: [],
    cartItems: []
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
