<template>
  <div class="flex justify-center items-center min-h-screen">
    <form @submit.prevent="login" class="w-96 p-8 bg-white shadow-md rounded-lg">
      <h2 class="text-xl font-bold mb-4 text-gray-800">Bejelentkezés</h2>
      <div>
        <label for="email" class="block text-sm text-gray-700">E-mail</label>
        <input type="email" v-model="email" id="email" class="w-full p-2 border rounded-md" required />
      </div>
      <div class="mt-4">
        <label for="password" class="block text-sm text-gray-700">Jelszó</label>
        <input type="password" v-model="password" id="password" class="w-full p-2 border rounded-md" required />
      </div>
      <button type="submit" class="w-full mt-6 bg-blue-500 text-white p-2 rounded-md">Bejelentkezés</button>
    </form>
  </div>
</template>

<script>
import {http} from "@utils/http";

export default {
  data() {
    return {
      email: "",
      password: "",
    };
  },
  methods: {
    async login() {
      try {
        const response = await http.post("http://backend.vm1.test/api/login", {
          email: this.email,
          password: this.password,
        });
        localStorage.setItem("token", response.data.token);
        this.$router.push("/landing"); // Maradunk a Landing oldalon
        window.location.reload(); // Navbar frissítése
      } catch (error) {
        alert("Hibás bejelentkezési adatok!");
      }
    },
  },
};
</script>

<route lang="json">
  {
      "name": "Login",
      "meta":{
          "title": "Bejelentkezés kezelése "
      }
  }
  </route>