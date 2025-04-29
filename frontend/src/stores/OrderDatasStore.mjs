import { defineStore } from 'pinia';
import {http} from '@utils/http';

export const useOrderDatasStore = defineStore('orderDatas', {
  state: () => ({
    orders: [],
  }),

  actions: {
    async createOrder(orderData) {
      try {
        const response = await http.post('orders', orderData);
        this.orders.push(response.data);
        return response.data;
      } catch (error) {
        console.error('Order creation failed:', error);
        throw error;
      }
    },
  },
});
