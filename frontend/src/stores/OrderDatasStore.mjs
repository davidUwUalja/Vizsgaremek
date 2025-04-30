import { defineStore } from 'pinia';
import { http } from '@utils/http';

export const useOrderDatasStore = defineStore('orderDatas', {
  state: () => ({
    orders: [],
  }),

  actions: {
    async fetchAllOrders() {
      const response = await http.get('/orders');
      this.orders = response.data;
      return response.data;
    },

    async updateOrderStatus(orderId, newStatus) {
      try {
        const response = await http.put(`/orders/${orderId}`, { status: newStatus });
        // Frissítsd a helyi orders tömböt is, ha van ilyen
        const idx = this.orders.findIndex(o => o.id === orderId);
        if (idx !== -1) {
          this.orders[idx].status = newStatus;
        }
        return response.data;
      } catch (error) {
        console.error('Order status update failed:', error);
        throw error;
      }
    },

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