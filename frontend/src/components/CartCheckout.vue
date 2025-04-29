<template>
  <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-yellow-50 p-6 rounded-lg shadow-lg max-w-md w-full border-2 border-yellow-800 max-h-screen overflow-y-auto">
      <div class="flex justify-between items-center mb-4 pb-2 border-b-2 border-yellow-700">
        <h2 class="text-2xl font-bold text-yellow-800 tracking-wide font-serif">
          {{ $t('payment') }}
        </h2>
        <button
          @click="$emit('close')"
          class="text-yellow-700 hover:text-yellow-900 transition-colors duration-200 text-xl"
        >
          ✕
        </button>
      </div>

      <div class="mb-4 border-b-2 border-yellow-700 pb-4">
        <h3 class="text-lg font-semibold text-yellow-800 mb-3"> {{ $t('contactinfo') }}</h3>
        
        <div class="mb-3">
          <label class="block mb-2 text-yellow-800 font-medium">
            {{ $t('fullname') }}
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
            Email
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
        <h3 class="text-lg font-semibold text-yellow-800 mb-3"> {{ $t('shipping') }}</h3>
        
        <div class="mb-3">
          <label class="block mb-2 text-yellow-800 font-medium">
            {{ $t('street') }}
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
              {{ $t('city') }}
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
               {{ $t('postalcode') }}
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
        <h3 class="text-lg font-semibold text-yellow-800 mb-3"> {{ $t('paymentDetails') }}</h3>
        
        <div class="mb-3">
          <label class="block mb-2 text-yellow-800 font-medium">
            {{ $t('currency') }}
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
            {{ $t('total') }}: {{ convertedPrice.toFixed(0) }} {{ currencySymbol }}
          </p>
        </div>

        <div class="mb-3">
          <label class="block mb-2 text-yellow-800 font-medium">
             {{ $t('cardNumber') }}
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
               {{ $t('expiryDate') }}
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
          {{ $t('Confirm') }}
        </button>

        <button
          @click="$emit('close')"
          class="w-full px-4 py-3 bg-red-700 text-red-50 font-serif font-semibold rounded-sm border-2 border-red-800 hover:bg-red-900 transition-all duration-300 shadow-md hover:shadow-xl"
        >
           {{ $t('Cancel') }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { useOrderDatasStore } from '@/stores/OrderDatasStore.mjs';
import { ref, computed, watch, onMounted } from 'vue';
import { useI18n } from 'vue-i18n';

export default {
  props: {
    totalPrice: {
      type: Number,
      required: true,
    },
  },
  setup(props, { emit }) {
    const orderStore = useOrderDatasStore();
    const { locale } = useI18n(); // Nyelv figyelése

    const fullName = ref('');
    const email = ref('');
    const streetAddress = ref('');
    const city = ref('');
    const zipCode = ref('');
    const cardNumber = ref('');
    const expiryDate = ref('');
    const cvv = ref('');
    const selectedCurrency = ref('HUF'); // Mindig forint az alapértelmezett
    const convertedPrice = ref(props.totalPrice); // Alapértelmezett ár forintban
    const exchangeRate = 370;

    const errors = ref({
      fullName: '',
      email: '',
      streetAddress: '',
      city: '',
      zipCode: '',
      cardNumber: '',
      expiryDate: '',
      cvv: '',
    });

    const currencySymbol = computed(() => {
      return selectedCurrency.value === 'HUF' ? 'Ft' : '$';
    });

    const isFormValid = computed(() => {
      return (
        fullName.value &&
        email.value &&
        streetAddress.value &&
        city.value &&
        zipCode.value &&
        cardNumber.value &&
        expiryDate.value &&
        cvv.value &&
        !Object.values(errors.value).some(error => error)
      );
    });

    const convertPrice = () => {
      if(locale.value==='en') {
        if(selectedCurrency.value === 'HUF'){
          convertedPrice.value = props.totalPrice * exchangeRate; // Angol nyelv esetén szorozzuk meg 370-nel
        }
        if(selectedCurrency.value === 'USD'){
          convertedPrice.value = props.totalPrice; // Angol nyelv esetén marad dollár
        }
      }
      if(locale.value==='hu') {
        if(selectedCurrency.value === 'HUF'){
          convertedPrice.value = props.totalPrice; // Magyar nyelv esetén marad forint
        }
        if(selectedCurrency.value === 'USD'){
          convertedPrice.value = props.totalPrice / exchangeRate; // Magyar nyelv esetén osszuk el az árfolyammal
        }
      }
    };

    // Nyelv figyelése és ár frissítése
    watch(locale, (newLocale) => {

      if (newLocale === 'en') {
        convertedPrice.value = props.totalPrice * exchangeRate; // Angol nyelv esetén szorozzuk meg 370-nel
        selectedCurrency.value = 'HUF'; // Alapértelmezett valuta dollár
      } else {
        convertedPrice.value = props.totalPrice; // Más nyelv esetén marad forint
        selectedCurrency.value = 'HUF'; // Alapértelmezett valuta forint
      }
    });

    // Nyelvváltás figyelése
    onMounted(() => {
      const navbar = document.querySelector('nav');
      navbar.addEventListener('languageChanged', (event) => {
        const newLocale = event.detail;
        if (newLocale === 'en') {
          convertedPrice.value = props.totalPrice * exchangeRate; // Angol nyelv esetén szorozzuk meg 370-nel
          selectedCurrency.value = 'HUF'; // Alapértelmezett valuta forint
        } else {
          convertedPrice.value = props.totalPrice; // Más nyelv esetén marad forint
          selectedCurrency.value = 'HUF'; // Alapértelmezett valuta forint
        }

      });

      if(locale.value === 'en') {
        props.totalPrice = props.totalPrice * exchangeRate; // Angol nyelv esetén szorozzuk meg 370-nel
        selectedCurrency.value = 'USD'; // Alapértelmezett valuta dollár
      } 
      if(locale.value === 'hu') {
        convertedPrice.value = props.totalPrice; // Más nyelv esetén marad forint
        selectedCurrency.value = 'HUF'; // Alapértelmezett valuta forint
      }

      logCurrentLanguage(); // Kiírja a nyelvet a konzolra, amikor a komponens betöltődik
    });

    const logCurrentLanguage = () => {
      console.log(`Current language: ${locale.value}`);
    };

    const validateName = () => {
      const regex = /^[A-Za-z\s]+$/;
      if (!fullName.value) {
        errors.value.fullName = 'Name is required';
      } else if (!regex.test(fullName.value)) {
        errors.value.fullName = 'Only letters are allowed';
        fullName.value = fullName.value.replace(/[^A-Za-z\s]/g, '');
      } else {
        errors.value.fullName = '';
      }
    };

    const validateEmail = () => {
      const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
      if (!email.value) {
        errors.value.email = 'Email is required';
      } else if (!regex.test(email.value)) {
        errors.value.email = 'Enter a valid email';
      } else {
        errors.value.email = '';
      }
    };

    const validateCity = () => {
      const regex = /^[A-Za-z\s]+$/;
      if (!city.value) {
        errors.value.city = 'City is required';
      } else if (!regex.test(city.value)) {
        errors.value.city = 'Only letters are allowed';
        city.value = city.value.replace(/[^A-Za-z\s]/g, '');
      } else {
        errors.value.city = '';
      }
    };

    const validateZipCode = () => {
      if (!zipCode.value) {
        errors.value.zipCode = 'Postal code is required';
      } else if (!/^\d+$/.test(zipCode.value)) {
        errors.value.zipCode = 'Only numbers allowed';
        zipCode.value = zipCode.value.replace(/\D/g, '');
      } else if (zipCode.value.length !== 4) {
        errors.value.zipCode = 'Must be exactly 4 digits';
      } else {
        errors.value.zipCode = '';
      }
    };

    const formatCardNumber = () => {
      let value = cardNumber.value.replace(/\D/g, '');
      let formatted = '';
      for (let i = 0; i < value.length; i++) {
        if (i > 0 && i % 4 === 0) formatted += ' ';
        formatted += value[i];
      }
      cardNumber.value = formatted;

      if (value.length !== 16) {
        errors.value.cardNumber = 'Must be 16 digits';
      } else {
        errors.value.cardNumber = '';
      }
    };

    const formatExpiryDate = () => {
      let value = expiryDate.value.replace(/\D/g, '');
      if (value.length >= 3) {
        expiryDate.value = value.slice(0, 2) + '/' + value.slice(2, 4);
      } else {
        expiryDate.value = value;
      }
    };

    const validateExpiryDate = () => {
      if (!expiryDate.value) {
        errors.value.expiryDate = 'Expiry is required';
        return;
      }
      if (!/^\d{2}\/\d{2}$/.test(expiryDate.value)) {
        errors.value.expiryDate = 'Use MM/YY format';
        return;
      }
      const [mm, yy] = expiryDate.value.split('/').map(Number);
      const expiry = new Date(2000 + yy, mm);
      const now = new Date();
      if (mm < 1 || mm > 12) {
        errors.value.expiryDate = 'Invalid month';
      } else if (expiry < now) {
        errors.value.expiryDate = 'Card expired';
      } else {
        errors.value.expiryDate = '';
      }
    };

    const validateCVV = () => {
      cvv.value = cvv.value.replace(/\D/g, '');
      if (!cvv.value) {
        errors.value.cvv = 'CVV required';
      } else if (cvv.value.length !== 3) {
        errors.value.cvv = 'Must be 3 digits';
      } else {
        errors.value.cvv = '';
      }
    };

    const validateAllFields = () => {
      validateName();
      validateEmail();
      validateCity();
      validateZipCode();
      validateExpiryDate();
      validateCVV();

      if (!streetAddress.value) {
        errors.value.streetAddress = 'Address required';
      } else {
        errors.value.streetAddress = '';
      }

      if (!cardNumber.value) {
        errors.value.cardNumber = 'Card number required';
      } else if (cardNumber.value.replace(/\s/g, '').length !== 16) {
        errors.value.cardNumber = 'Must be 16 digits';
      }
    };

    const confirmPayment = async () => {
      validateAllFields();
      if (isFormValid.value) {
        const orderData = {
          user_id: 1,
          name: fullName.value,
          email: email.value,
          address: streetAddress.value,
          city: city.value,
          zip: zipCode.value,
          currency: selectedCurrency.value,
          total_price: Math.round(convertedPrice.value),
          status: 'pending',
        };

        try {
          await orderStore.createOrder(orderData);
          alert('Order placed successfully!');
          emit('close');
        } catch (error) {
          console.error(error);
          alert('Failed to place order.');
        }
      } else {
        alert('Please fill out the form correctly!');
      }
    };

    return {
      fullName,
      email,
      streetAddress,
      city,
      zipCode,
      cardNumber,
      expiryDate,
      cvv,
      selectedCurrency,
      convertedPrice,
      exchangeRate,
      currencySymbol,
      errors,
      isFormValid,
      convertPrice,
      validateName,
      validateEmail,
      validateCity,
      validateZipCode,
      formatCardNumber,
      formatExpiryDate,
      validateExpiryDate,
      validateCVV,
      confirmPayment,
      logCurrentLanguage,
    };
  },
};
</script>
