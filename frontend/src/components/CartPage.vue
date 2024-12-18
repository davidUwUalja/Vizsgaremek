<template>
    <div class="min-h-screen bg-gray-100 flex flex-col items-center py-8">
      <h1 class="text-3xl font-bold mb-6">Kosár</h1>
  
      <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-semibold mb-4">Kosár</h2>
        <div v-if="basket.length === 0" class="text-gray-600 text-center">
          A kosarad üres.
        </div>
        <div v-else>
          <div v-for="item in basket" :key="item.id" class="mb-4 flex justify-between items-center">
            <div>
              <p class="text-lg">{{ item.name }}</p>
              <p class="text-gray-600 text-sm">{{ item.price.toFixed(2) }} Ft</p>
            </div>
            <button
              @click="removeFromBasket(item)"
              class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
            >
              Törlés
            </button>
          </div>
          <div class="border-t pt-4 mt-4">
            <p class="text-lg font-semibold">Összesen: {{ totalPrice.toFixed(2) }} Ft</p>
          </div>
          <button
            @click="proceedToCheckout"
            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mt-4 w-full"
          >
            Tovább a fizetéshez
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        products: [
          { id: 1, name: 'Termék A', price: 1000 },
          { id: 2, name: 'Termék B', price: 1500 },
          { id: 3, name: 'Termék C', price: 2000 },
        ],
        basket: [
          { id: 1, name: 'Termék A', price: 1000 },
          { id: 2, name: 'Termék B', price: 1500 },
        ], 
      };
    },
    computed: {
      totalPrice() {
        return this.basket.reduce((sum, item) => sum + item.price, 0);
      },
    },
    methods: {
      removeFromBasket(product) {
        const index = this.basket.findIndex((item) => item.id === product.id);
        if (index !== -1) {
          this.basket.splice(index, 1);
        }
      },
      proceedToCheckout() {
        alert('Tovább a fizetéshez. Összesen: ' + this.totalPrice.toFixed(2) + ' Ft');
      },
    },
  };
  </script>