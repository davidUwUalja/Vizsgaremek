<template>
    <div v-if="isOpen" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
      <div class="relative bg-white p-6 rounded-lg shadow-lg w-96">
        <button @click="closeModal" class="absolute top-2 right-2 text-gray-600 text-2xl hover:text-gray-800">
          &times;
        </button>
  
        <h2 class="text-xl font-bold mb-4 text-gray-800 text-center">
          {{ isLogin ? $t('login') : $t('registering') }}
        </h2>
  
        <form @submit.prevent="isLogin ? login() : register()">
          <div v-if="!isLogin">
            <label class="block text-sm text-gray-700">{{ $t('name') }}</label>
            <input 
              type="text" 
              v-model="name" 
              class="w-full p-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
              required 
            />
          </div>
  
          <div class="mt-4">
            <label class="block text-sm text-gray-700">E-mail</label>
            <input 
              type="email" 
              v-model="email" 
              class="w-full p-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
              required 
            />
          </div>
  
          <div class="mt-4">
            <label class="block text-sm text-gray-700">{{ $t('password') }}</label>
            <input 
              type="password" 
              v-model="password" 
              class="w-full p-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
              required 
            />
          </div>
  
          <div class="mt-4" v-if="!isLogin">
            <label class="block text-sm text-gray-700">{{ $t('repassword') }}</label>
            <input 
              type="password" 
              v-model="password_confirmation" 
              class="w-full p-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
              required 
            />
          </div>
  
          <button type="submit" class="w-full mt-6 bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 transition">
            {{ isLogin ? $t('login') : $t('registering') }}
          </button>
        </form>
  
        <button @click="toggleMode" class="mt-4 text-blue-500 underline w-full text-center block hover:text-blue-700 transition">
          {{ isLogin ? $t('register')  : $t('loginMessages') }}
        </button>
      </div>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    props: ["isOpen", "closeModal"],
    data() {
      return {
        isLogin: true,
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
      };
    },
    methods: {
      async login() {
        try {
          const response = await axios.post("http://backend.vm1.test/api/login", {
            email: this.email,
            password: this.password,
          });
          localStorage.setItem("token", response.data.data.token);
          this.closeModal();
          window.location.reload();
        } catch (error) {
          alert("Hibás bejelentkezési adatok!");
        }
      },
      async register() {
        try {
          const response = await axios.post("http://backend.vm1.test/api/register", {
            name: this.name,
            email: this.email,
            password: this.password,
            password_confirmation: this.password_confirmation,
          });
          localStorage.setItem("token", response.data.token);
          this.closeModal();
          window.location.reload();
        } catch (error) {
          alert("Hiba történt a regisztráció során.");
        }
      },
      toggleMode() {
        this.isLogin = !this.isLogin;
      },
    },
  };
  </script>
  