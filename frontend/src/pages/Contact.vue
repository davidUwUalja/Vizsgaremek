<template>
  <div class="min-h-screen bg-gray-100 p-6 flex flex-col items-center">
    <div class="max-w-5xl w-full bg-white p-8 shadow-lg rounded-md">
      <h1 class="text-4xl font-bold text-center text-blue-600 mb-8">Kézműves Kazah Webshop</h1>
      
      <div class="flex flex-col md:flex-row items-center md:items-start">
        <div class="md:w-1/2 text-gray-700 pr-6">
          <h2 class="text-2xl font-semibold text-blue-500 mb-4">Rólunk</h2>
          <p class="mb-4">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque elementum
            consequat magna, in gravida est convallis id. Nulla facilisi. Fusce auctor,
            metus nec convallis aliquet, justo turpis dictum erat, sed tempus justo elit
            at orci.
          </p>
          <p class="mb-4">
            A kézműves kazah termékek története több száz évre nyúlik vissza. Minden darab
            egyedi, és hagyományos technikákkal készül. A mesterek generációról generációra
            örökítik át tudásukat, hogy a modern világban is megőrizhessék a kultúrájukat.
          </p>
          <p class="mb-4">
            Termékeink között megtalálhatóak kézzel szőtt szőnyegek, egyedi ékszerek,
            bőrből készült kiegészítők és különféle dekorációs tárgyak. Minden egyes alkotásban
            ott rejlik a kazah népművészet szellemisége és precizitása.
          </p>
          <p class="mb-4">
            Vásárlóink számára garantáljuk a minőséget és az autentikus kézműves élményt.
            Célunk, hogy a világ bármely pontjára eljuttassuk a kazah kultúra szépségeit,
            és örömet szerezzünk azoknak, akik értékelik a valódi mestermunkát.
          </p>
        </div>
        <div class="md:w-1/2 grid grid-cols-2 gap-4">
          <img src="https://via.placeholder.com/300" alt="Kézműves termék 1" class="rounded-lg shadow-md" />
          <img src="https://via.placeholder.com/300" alt="Kézműves termék 2" class="rounded-lg shadow-md" />
          <img src="https://via.placeholder.com/300" alt="Kézműves termék 3" class="rounded-lg shadow-md" />
          <img src="https://via.placeholder.com/300" alt="Kézműves termék 4" class="rounded-lg shadow-md" />
        </div>
      </div>
      
      <div class="mt-12">
        <h2 class="text-2xl font-semibold text-blue-500 mb-4 text-center">Írj üzenetet!</h2>
        <form @submit.prevent="submitForm" class="max-w-lg mx-auto">
          <div class="mb-4">
            <label for="name" class="block text-gray-700 font-semibold">Név</label>
            <input
              id="name"
              type="text"
              v-model="form.name"
              placeholder="Add meg a neved"
              class="w-full border rounded-lg px-4 py-2 mt-1 shadow-sm"
            />
            <p v-if="errors.name" class="text-red-500 text-sm">{{ errors.name }}</p>
          </div>
          <div class="mb-4">
            <label for="email" class="block text-gray-700 font-semibold">Email</label>
            <input
              id="email"
              type="email"
              v-model="form.email"
              placeholder="Add meg az email címed"
              class="w-full border rounded-lg px-4 py-2 mt-1 shadow-sm"
            />
            <p v-if="errors.email" class="text-red-500 text-sm">{{ errors.email }}</p>
          </div>
          <div class="mb-4">
            <label for="message" class="block text-gray-700 font-semibold">Üzenet</label>
            <textarea
              id="message"
              rows="4"
              v-model="form.message"
              placeholder="Írd be az üzeneted"
              class="w-full border rounded-lg px-4 py-2 mt-1 shadow-sm"
            ></textarea>
            <p v-if="errors.message" class="text-red-500 text-sm">{{ errors.message }}</p>
          </div>
          <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 w-full font-semibold shadow-md">
            Üzenet Küldése
          </button>
        </form>
        <p v-if="successMessage" class="text-green-600 text-center mt-4">{{ successMessage }}</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Contact',
  data() {
    return {
      form: {
        name: '',
        email: '',
        message: ''
      },
      errors: {},
      successMessage: ''
    };
  },
  methods: {
    validateForm() {
      this.errors = {};
      if (!this.form.name) {
        this.errors.name = 'A név megadása kötelező.';
      }
      if (!this.form.email) {
        this.errors.email = 'Az email megadása kötelező.';
      } else if (!/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(this.form.email)) {
        this.errors.email = 'Érvényes email címet adj meg.';
      }
      if (!this.form.message) {
        this.errors.message = 'Az üzenet nem lehet üres.';
      }
      return Object.keys(this.errors).length === 0;
    },
    submitForm() {
      if (this.validateForm()) {
        this.successMessage = 'Üzeneted sikeresen elküldve!';
        this.form.name = '';
        this.form.email = '';
        this.form.message = '';
      }
    }
  }
};
</script>
