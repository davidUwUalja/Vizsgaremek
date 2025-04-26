<template>
  <div class="flex justify-center items-center min-h-screen">
    <form @submit.prevent="register" class="w-96 p-8 bg-white shadow-md rounded-lg">
      <h2 class="text-xl font-bold mb-4 text-gray-800">Regisztráció</h2>
      <div>
        <label for="name" class="block text-sm text-gray-700">Név</label>
        <input
          type="text"
          v-model="name"
          id="name"
          class="w-full p-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
          required
        />
      </div>
      <div class="mt-4">
        <label for="email" class="block text-sm text-gray-700">E-mail</label>
        <input
          type="email"
          v-model="email"
          id="email"
          class="w-full p-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
          required
        />
      </div>
      <div class="mt-4">
        <label for="password" class="block text-sm text-gray-700">Jelszó</label>
        <input
          type="password"
          v-model="password"
          id="password"
          class="w-full p-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
          required
        />
      </div>
      <div class="mt-4">
        <label for="password_confirmation" class="block text-sm text-gray-700">Jelszó megerősítése</label>
        <input
          type="password"
          v-model="password_confirmation"
          id="password_confirmation"
          class="w-full p-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
          required
        />
      </div>
      <button type="submit" class="w-full mt-6 bg-blue-500 text-white p-2 rounded-md">Regisztráció</button>
    </form>
  </div>
</template>

<script>
import axios from "axios";
import { useRouter } from "vue-router";

export default {
  data() {
    return {
      name: "",
      email: "",
      password: "",
      password_confirmation: "",
    };
  },
  methods: {
    async register() {
      try {
        const response = await axios.post("http://backend.vm1.test/api/register", {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation, // Fontos: add hozzá ezt a mezőt is!
        });
        localStorage.setItem("token", response.data.token); 
        this.$router.push("/landing");
      } catch (error) {
        if (error.response && error.response.data) {
          console.error(error.response.data); // Hibaüzenet konzolra
          alert("Hiba történt a regisztráció során.");
        }
      }
    },
  },
};
</script>

<route lang="json">
{
    "name": "Register",
    "meta":{
        "title": "Regisztráció kezelése "
    }
}
</route>