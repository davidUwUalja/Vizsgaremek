<template>
    <nav class="bg-white shadow-md p-4 flex items-center justify-between">
      <div class="flex items-center space-x-6">
        <router-link to="/landing" class="text-gray-700 hover:text-blue-500">Főoldal</router-link>
        <router-link to="/products" class="text-gray-700 hover:text-blue-500">Termékek</router-link>
        <router-link to="/contact" class="text-gray-700 hover:text-blue-500">Kapcsolat</router-link>
      </div>
  
      <div class="flex items-center space-x-4">
        <button v-if="!isAuthenticated" @click="openModal" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
          Bejelentkezés / Regisztráció
        </button>
  
        <div v-else class="relative">
          <button @click="toggleProfileMenu" class="text-gray-700 text-xl">👤</button>
          <div v-if="isProfileMenuOpen" class="absolute right-0 bg-white shadow-lg rounded-md mt-2 w-40 z-10">
            <ul>
              <li class="p-2 hover:bg-red-100 cursor-pointer text-gray-500">Számlák</li>
              <li @click="$router.push('/settings')" class="p-2 hover:bg-red-100 cursor-pointer text-gray-500">Beállítások</li>
              <li @click="$emit('logout')" class="p-2 hover:bg-red-100 cursor-pointer text-red-500">Kilépés</li>
            </ul>
          </div>
        </div>
      </div>
  
      <AuthModal :isOpen="isModalOpen" :closeModal="closeModal" />
    </nav>
  </template>
  
  <script>
  import AuthModal from "@/components/AuthModal.vue";
  
  export default {
    components: { AuthModal },
    props: {
      isAuthenticated: Boolean,
    },
    data() {
      return {
        isModalOpen: false,
        isProfileMenuOpen: false,
      };
    },
    methods: {
      openModal() {
        this.isModalOpen = true;
      },
      closeModal() {
        this.isModalOpen = false;
      },
      toggleProfileMenu() {
        this.isProfileMenuOpen = !this.isProfileMenuOpen;
      },
    },
  };
  </script>
  