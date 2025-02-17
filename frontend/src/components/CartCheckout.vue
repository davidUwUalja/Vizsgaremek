<template>
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
      <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-xl font-semibold mb-4">Fizetés</h2>
        <p class="mb-4">Összeg: {{ totalPrice }} Ft</p>
        <label class="block mb-2">Kártyaszám</label>
        <input type="text" v-model="cardNumber" class="border p-2 rounded w-full mb-4" placeholder="1234 5678 9012 3456" />
        
        <label class="block mb-2">Lejárati dátum</label>
        <input type="text" v-model="expiryDate" class="border p-2 rounded w-full mb-4" placeholder="MM/YY" />
        
        <label class="block mb-2">CVV</label>
        <input type="text" v-model="cvv" class="border p-2 rounded w-full mb-4" placeholder="123" />
        
        <button @click="confirmPayment" class="bg-green-500 text-white px-4 py-2 rounded w-full hover:bg-green-600">
          Fizetés megerősítése
        </button>
        <button @click="$emit('close')" class="mt-2 bg-red-500 text-white px-4 py-2 rounded w-full hover:bg-red-600">
          Mégse
        </button>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      totalPrice: {
        type: Number,
        required: true,
      },
    },
    data() {
      return {
        cardNumber: '',
        expiryDate: '',
        cvv: '',
      };
    },
    methods: {
      confirmPayment() {
        if (this.cardNumber && this.expiryDate && this.cvv) {
          this.$emit('confirm-payment');
        } else {
          alert('Kérlek töltsd ki az összes mezőt!');
        }
      },
    },
  };
  </script>  