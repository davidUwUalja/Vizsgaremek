<template>
  <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-yellow-50 p-6 rounded-lg shadow-lg w-96 border-2 border-yellow-800">
      <div class="flex justify-between items-center mb-4 pb-2 border-b-2 border-yellow-700">
        <h2 class="text-2xl font-bold text-yellow-800 tracking-wide font-serif">
          {{ $t('payment')}}
        </h2>
        <button
          @click="$emit('close')"
          class="text-yellow-700 hover:text-yellow-900 transition-colors duration-200 text-xl"
        >
          ✕
        </button>
      </div>

      <div class="mb-4">
        <label class="block mb-2 text-yellow-800 font-medium">
          {{ $t('currency') || 'Currency' }}
        </label>
        <select
          v-model="selectedCurrency"
          @change="convertPrice"
          class="border-2 border-yellow-700 p-2 rounded-sm w-full bg-white focus:outline-none focus:ring-2 focus:ring-yellow-600"
        >
          <option value="HUF">HUF</option>
          <option value="USD">USD</option>
        </select>
      </div>

      <div class="mb-6 py-2 bg-yellow-100 px-4 rounded-sm border border-yellow-700">
        <p class="text-lg font-semibold text-yellow-800">
          {{ $t('total') || 'Total' }}: {{ convertedPrice.toFixed(2) }} {{ currencySymbol }}
        </p>
      </div>

      <div class="space-y-4">
        <div>
          <label class="block mb-2 text-yellow-800 font-medium">
            {{ $t('cardNumber') || 'Card Number' }}
          </label>
          <input
            type="text"
            v-model="cardNumber"
            class="border-2 border-yellow-700 p-2 rounded-sm w-full bg-white focus:outline-none focus:ring-2 focus:ring-yellow-600"
            placeholder="1234 5678 9012 3456"
          />
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block mb-2 text-yellow-800 font-medium">
              {{ $t('expiryDate') || 'Expiry Date' }}
            </label>
            <input
              type="text"
              v-model="expiryDate"
              class="border-2 border-yellow-700 p-2 rounded-sm w-full bg-white focus:outline-none focus:ring-2 focus:ring-yellow-600"
              placeholder="MM/YY"
            />
          </div>

          <div>
            <label class="block mb-2 text-yellow-800 font-medium">
              CCV
            </label>
            <input
              type="text"
              v-model="cvv"
              class="border-2 border-yellow-700 p-2 rounded-sm w-full bg-white focus:outline-none focus:ring-2 focus:ring-yellow-600"
              placeholder="123"
            />
          </div>
        </div>
      </div>

      <div class="mt-6 space-y-3">
        <button
          @click="confirmPayment"
          class="w-full px-4 py-3 bg-yellow-700 text-yellow-50 font-serif font-semibold rounded-sm border-2 border-yellow-800 hover:bg-yellow-900 transition-all duration-300 shadow-md hover:shadow-xl"
        >
          {{ $t('Confirm') || 'Confirm Payment' }}
        </button>

        <button
          @click="$emit('close')"
          class="w-full px-4 py-3 bg-red-700 text-red-50 font-serif font-semibold rounded-sm border-2 border-red-800 hover:bg-red-900 transition-all duration-300 shadow-md hover:shadow-xl"
        >
          {{ $t('Cancel') || 'Cancel' }}
        </button>
      </div>
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
      selectedCurrency: 'HUF',
      convertedPrice: 0,
      exchangeRate: 370, 
      originalCurrency: 'HUF',
    };
  },
  computed: {
    currencySymbol() {
      return this.selectedCurrency === 'HUF' ? 'Ft' : '$';
    },
  },
  mounted() {
    this.originalCurrency = this.$i18n.locale === 'hu' ? 'HUF' : 'USD';
    this.selectedCurrency = this.originalCurrency;
    this.convertedPrice = this.totalPrice;
  },
  methods: {
    convertPrice() {
      if (this.selectedCurrency === this.originalCurrency) {
        this.convertedPrice = this.totalPrice;
      } else if (this.selectedCurrency === 'USD') {
        this.convertedPrice =
          this.originalCurrency === 'HUF'
            ? this.totalPrice / this.exchangeRate
            : this.totalPrice;
      } else {
        this.convertedPrice =
          this.originalCurrency === 'USD'
            ? this.totalPrice * this.exchangeRate
            : this.totalPrice;
      }
    },
    confirmPayment() {
      if (this.validateForm()) {
        this.$emit('confirm-payment', {
          cardNumber: this.cardNumber,
          expiryDate: this.expiryDate,
          cvv: this.cvv,
          currency: this.selectedCurrency,
          amount: this.convertedPrice,
        });
      } else {
        alert(this.$t('fillAllFields') || 'Please fill all fields correctly!');
      }
    },
    validateForm() {
      return this.cardNumber && this.expiryDate && this.cvv;
    },
  },
};
</script>
