<template>
  <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-yellow-50 p-6 rounded-lg shadow-lg max-w-md w-full border-2 border-yellow-800 max-h-screen overflow-y-auto">
      <div class="flex justify-between items-center mb-4 pb-2 border-b-2 border-yellow-700">
        <h2 class="text-2xl font-bold text-yellow-800 tracking-wide font-serif">
          Payment
        </h2>
        <button
          @click="$emit('close')"
          class="text-yellow-700 hover:text-yellow-900 transition-colors duration-200 text-xl"
        >
          ✕
        </button>
      </div>

      <div class="mb-4 border-b-2 border-yellow-700 pb-4">
        <h3 class="text-lg font-semibold text-yellow-800 mb-3">Contact Information</h3>
        
        <div class="mb-3">
          <label class="block mb-2 text-yellow-800 font-medium">
            Full Name
          </label>
          <input
            type="text"
            v-model="fullName"
            @input="validateName"
            class="border-2 border-yellow-700 p-2 rounded-sm w-full bg-white focus:outline-none focus:ring-2 focus:ring-yellow-600"
            placeholder="John Doe"
          />
          <p v-if="errors.fullName" class="mt-1 text-sm text-red-600">{{ errors.fullName }}</p>
        </div>

        <div class="mb-3">
          <label class="block mb-2 text-yellow-800 font-medium">
            Email Address
          </label>
          <input
            type="email"
            v-model="email"
            @input="validateEmail"
            class="border-2 border-yellow-700 p-2 rounded-sm w-full bg-white focus:outline-none focus:ring-2 focus:ring-yellow-600"
            placeholder="example@email.com"
          />
          <p v-if="errors.email" class="mt-1 text-sm text-red-600">{{ errors.email }}</p>
        </div>
      </div>

      <div class="mb-4 border-b-2 border-yellow-700 pb-4">
        <h3 class="text-lg font-semibold text-yellow-800 mb-3">Shipping Address</h3>
        
        <div class="mb-3">
          <label class="block mb-2 text-yellow-800 font-medium">
            Street Address
          </label>
          <input
            type="text"
            v-model="streetAddress"
            class="border-2 border-yellow-700 p-2 rounded-sm w-full bg-white focus:outline-none focus:ring-2 focus:ring-yellow-600"
            placeholder="Ember utca 11"
          />
          <p v-if="errors.streetAddress" class="mt-1 text-sm text-red-600">{{ errors.streetAddress }}</p>
        </div>

        <div class="grid grid-cols-2 gap-3 mb-3">
          <div>
            <label class="block mb-2 text-yellow-800 font-medium">
              City
            </label>
            <input
              type="text"
              v-model="city"
              @input="validateCity"
              class="border-2 border-yellow-700 p-2 rounded-sm w-full bg-white focus:outline-none focus:ring-2 focus:ring-yellow-600"
              placeholder="City"
            />
            <p v-if="errors.city" class="mt-1 text-sm text-red-600">{{ errors.city }}</p>
          </div>

          <div>
            <label class="block mb-2 text-yellow-800 font-medium">
              Postal Code
            </label>
            <input
              type="text"
              v-model="zipCode"
              @input="validateZipCode"
              maxlength="4"
              class="border-2 border-yellow-700 p-2 rounded-sm w-full bg-white focus:outline-none focus:ring-2 focus:ring-yellow-600"
              placeholder="1234"
            />
            <p v-if="errors.zipCode" class="mt-1 text-sm text-red-600">{{ errors.zipCode }}</p>
          </div>
        </div>
      </div>

      <div class="mb-4">
        <h3 class="text-lg font-semibold text-yellow-800 mb-3">Payment Details</h3>
        
        <div class="mb-3">
          <label class="block mb-2 text-yellow-800 font-medium">
            Currency
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

        <div class="mb-4 py-2 bg-yellow-100 px-4 rounded-sm border border-yellow-700">
          <p class="text-lg font-semibold text-yellow-800">
            Total: {{ convertedPrice.toFixed(0) }} {{ currencySymbol }}
          </p>
        </div>

        <div class="mb-3">
          <label class="block mb-2 text-yellow-800 font-medium">
            Card Number
          </label>
          <input
            type="text"
            v-model="cardNumber"
            @input="formatCardNumber"
            maxlength="19"
            class="border-2 border-yellow-700 p-2 rounded-sm w-full bg-white focus:outline-none focus:ring-2 focus:ring-yellow-600"
            placeholder="1234 5678 9012 3456"
          />
          <p v-if="errors.cardNumber" class="mt-1 text-sm text-red-600">{{ errors.cardNumber }}</p>
        </div>

        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="block mb-2 text-yellow-800 font-medium">
              Expiry Date
            </label>
            <input
              type="text"
              v-model="expiryDate"
              @input="formatExpiryDate"
              @blur="validateExpiryDate"
              maxlength="5"
              class="border-2 border-yellow-700 p-2 rounded-sm w-full bg-white focus:outline-none focus:ring-2 focus:ring-yellow-600"
              placeholder="MM/YY"
            />
            <p v-if="errors.expiryDate" class="mt-1 text-sm text-red-600">{{ errors.expiryDate }}</p>
          </div>

          <div>
            <label class="block mb-2 text-yellow-800 font-medium">
              CCV
            </label>
            <input
              type="text"
              v-model="cvv"
              @input="validateCVV"
              maxlength="3"
              class="border-2 border-yellow-700 p-2 rounded-sm w-full bg-white focus:outline-none focus:ring-2 focus:ring-yellow-600"
              placeholder="123"
            />
            <p v-if="errors.cvv" class="mt-1 text-sm text-red-600">{{ errors.cvv }}</p>
          </div>
        </div>
      </div>

      <div class="mt-6 space-y-3">
        <button
          @click="confirmPayment"
          class="w-full px-4 py-3 bg-yellow-700 text-yellow-50 font-serif font-semibold rounded-sm border-2 border-yellow-800 hover:bg-yellow-900 transition-all duration-300 shadow-md hover:shadow-xl"
        >
          Confirm Payment
        </button>

        <button
          @click="$emit('close')"
          class="w-full px-4 py-3 bg-red-700 text-red-50 font-serif font-semibold rounded-sm border-2 border-red-800 hover:bg-red-900 transition-all duration-300 shadow-md hover:shadow-xl"
        >
          Cancel
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
      fullName: '',
      email: '',
      
      streetAddress: '',
      city: '',
      zipCode: '',
      
      cardNumber: '',
      expiryDate: '',
      cvv: '',
      selectedCurrency: 'HUF',
      convertedPrice: 0,
      exchangeRate: 370, 
      originalCurrency: 'HUF',
      
      errors: {
        fullName: '',
        email: '',
        streetAddress: '',
        city: '',
        zipCode: '',
        cardNumber: '',
        expiryDate: '',
        cvv: '',
      }
    };
  },
  computed: {
    currencySymbol() {
      return this.selectedCurrency === 'HUF' ? 'Ft' : '$';
    },
    isFormValid() {
      return (
        this.fullName && 
        this.email && 
        this.streetAddress && 
        this.city && 
        this.zipCode && 
        this.cardNumber && 
        this.expiryDate && 
        this.cvv &&
        !Object.values(this.errors).some(error => error)
      );
    }
  },
  mounted() {
    this.originalCurrency = 'HUF';
    this.selectedCurrency = this.originalCurrency;
    this.convertedPrice = this.totalPrice;
  },
  methods: {
    validateName() {
      const nameRegex = /^[A-Za-z\s]+$/;
      if (!this.fullName) {
        this.errors.fullName = 'Name is required';
      } else if (!nameRegex.test(this.fullName)) {
        this.errors.fullName = 'Only letters are allowed';
        this.fullName = this.fullName.replace(/[^A-Za-z\s]/g, '');
      } else {
        this.errors.fullName = '';
      }
    },
    
    validateEmail() {
      const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
      if (!this.email) {
        this.errors.email = 'Email is required';
      } else if (!emailRegex.test(this.email)) {
        this.errors.email = 'Please enter a valid email address';
      } else {
        this.errors.email = '';
      }
    },
    
    validateCity() {
      const cityRegex = /^[A-Za-z\s]+$/;
      if (!this.city) {
        this.errors.city = 'City is required';
      } else if (!cityRegex.test(this.city)) {
        this.errors.city = 'Only letters are allowed';
        this.city = this.city.replace(/[^A-Za-z\s]/g, '');
      } else {
        this.errors.city = '';
      }
    },
    
    validateZipCode() {
      const zipRegex = /^[0-9]+$/;
      if (!this.zipCode) {
        this.errors.zipCode = 'Postal code is required';
      } else if (!zipRegex.test(this.zipCode)) {
        this.errors.zipCode = 'Only numbers are allowed';
        this.zipCode = this.zipCode.replace(/[^0-9]/g, '');
      } else if (this.zipCode.length !== 4) {
        this.errors.zipCode = 'Postal code must be exactly 4 digits';
      } else {
        this.errors.zipCode = '';
      }
    },
    
    formatCardNumber() {
      let value = this.cardNumber.replace(/\D/g, '');
      
      if (!/^\d*$/.test(value)) {
        this.errors.cardNumber = 'Only numbers are allowed';
      } else {
        this.errors.cardNumber = '';
      }
      
      let formattedValue = '';
      for (let i = 0; i < value.length; i++) {
        if (i > 0 && i % 4 === 0) {
          formattedValue += ' ';
        }
        formattedValue += value[i];
      }
      
      this.cardNumber = formattedValue;
      
      if (value.length > 0 && value.length < 16) {
        this.errors.cardNumber = 'Card number must be 16 digits';
      } else {
        this.errors.cardNumber = '';
      }
    },
    
    formatExpiryDate() {
      let value = this.expiryDate.replace(/\D/g, '');
      
      if (value.length > 0) {
        if (value.length <= 2) {
          this.expiryDate = value;
        } else {
          this.expiryDate = value.substring(0, 2) + '/' + value.substring(2, 4);
        }
      }
      
      if (value.length >= 2) {
        const month = parseInt(value.substring(0, 2));
        if (month < 1 || month > 12) {
          this.errors.expiryDate = 'Invalid month (must be 01-12)';
        } else {
          this.errors.expiryDate = '';
        }
      }
    },
    
    validateExpiryDate() {
      if (!this.expiryDate) {
        this.errors.expiryDate = 'Expiry date is required';
        return;
      }
      
      if (!/^\d{2}\/\d{2}$/.test(this.expiryDate)) {
        this.errors.expiryDate = 'Please use MM/YY format';
        return;
      }
      
      const [monthStr, yearStr] = this.expiryDate.split('/');
      const month = parseInt(monthStr);
      let year = parseInt(yearStr);
      
      year += 2000;
      
      const now = new Date();
      const currentMonth = now.getMonth() + 1; 
      const currentYear = now.getFullYear();
      
      if (month < 1 || month > 12) {
        this.errors.expiryDate = 'Invalid month (must be 01-12)';
        return;
      }
      
      const lastDayOfMonth = new Date(year, month, 0).getDate();
      const expiryDate = new Date(year, month - 1, lastDayOfMonth);
      const today = new Date();
      
      today.setHours(0, 0, 0, 0);
      
      if (expiryDate < today) {
        this.errors.expiryDate = 'Card has expired';
        return;
      }
      
      if (year > currentYear + 10) {
        this.errors.expiryDate = 'Date too far in the future';
        return;
      }
      
      this.errors.expiryDate = '';
    },
    
    validateCVV() {
      this.cvv = this.cvv.replace(/\D/g, '');
      
      if (!this.cvv) {
        this.errors.cvv = 'CVV is required';
      } else if (this.cvv.length !== 3) {
        this.errors.cvv = 'CVV must be 3 digits';
      } else {
        this.errors.cvv = '';
      }
    },

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
    
    validateAllFields() {
      this.validateName();
      this.validateEmail();
      this.validateCity();
      this.validateZipCode();
      this.validateExpiryDate();
      this.validateCVV();
      
      if (!this.streetAddress) {
        this.errors.streetAddress = 'Street address is required';
      } else {
        this.errors.streetAddress = '';
      }
      
      if (!this.cardNumber) {
        this.errors.cardNumber = 'Card number is required';
      } else if (this.cardNumber.replace(/\s/g, '').length !== 16) {
        this.errors.cardNumber = 'Card number must be 16 digits';
      } else {
        this.errors.cardNumber = '';
      }
    },
    
    confirmPayment() {
      this.validateAllFields();
      
      if (this.isFormValid) {
        this.$emit('confirm-payment', {
          fullName: this.fullName,
          email: this.email,
          
          streetAddress: this.streetAddress,
          city: this.city,
          zipCode: this.zipCode,
          
          cardNumber: this.cardNumber.replace(/\s/g, ''), 
          expiryDate: this.expiryDate,
          cvv: this.cvv,
          currency: this.selectedCurrency,
          amount: this.convertedPrice,
        });
      } else {
        alert('Please fill all required fields correctly!');
      }
    }
  },
};
</script>