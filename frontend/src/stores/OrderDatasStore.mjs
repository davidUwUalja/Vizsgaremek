import { defineStore } from 'pinia';
import axios from 'axios';

export const useOrderDatasStore = defineStore('orderDatas', {
  state: () => ({
    orders: [],
  }),

  actions: {
    async createOrder(orderData) {
      try {
        const response = await axios.post('http://backend.vm1.test/api/orders', orderData);
        this.orders.push(response.data);
        return response.data;
      } catch (error) {
        console.error('Order creation failed:', error);
        throw error;
      }
    },
  },
});
