import { defineStore } from "pinia";
import { http } from "@utils/http.mjs";

export const useProductStore = defineStore("product", {
  state: () => ({
    products: []
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
      console.log('Kosárhoz adva:', product);
    }
  },
  getters: {
    getLocalizedField: () => {
      return (product, field, locale) => {
        // elvárva, hogy a termékobjektum property-jei pl. name_hu és name_en legyenek
        return product[`${field}_${locale}`] || product[`${field}_hu`];
      };
    }
  }
});
