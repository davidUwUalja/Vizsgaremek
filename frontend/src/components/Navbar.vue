<template>
  <nav class="bg-white shadow-md p-4 flex items-center justify-between">
    <!-- Bal oldal - Nyelvválasztó -->
    <div class="flex items-center space-x-4">
      <div class="relative">
        <button
          @click="toggleLanguageMenu"
          class="text-gray-700 hover:bg-gray-200 p-2 rounded-md"
        >
          🌐 {{ $t("language") }}
        </button>
        <div
          v-if="isLanguageMenuOpen"
          class="absolute bg-white shadow-lg rounded-md mt-2 w-32 z-10"
        >
          <ul>
            <li @click="changeLanguage('hu')" class="p-2 hover:bg-gray-100 cursor-pointer">Magyar</li>
            <li @click="changeLanguage('en')"class="p-2 hover:bg-gray-100 cursor-pointer">English</li>
            <li @click="changeLanguage('de')" class="p-2 hover:bg-gray-100 cursor-pointer">Deutsch</li>
          </ul>
        </div>
      </div>
      <div class="flex items-center border rounded-md px-2">
        <input
          type="text"
          placeholder="Keresés..."
          class="outline-none text-gray-700 px-2 py-1 w-48"
          @keyup.enter="performSearch"
          v-model="searchQuery"
        />
        <button @click="performSearch" class="text-gray-500 ml-2">
          🔍
        </button>
      </div>
    </div>

    <!-- Középső rész - Oldalak -->
    <div class="flex items-center space-x-6">
      <router-link to="/" class="text-gray-700 hover:text-blue-500">Főoldal</router-link>
      <router-link to="/products" class="text-gray-700 hover:text-blue-500">Termékek</router-link>
      <router-link to="/contact" class="text-gray-700 hover:text-blue-500">Kapcsolat</router-link>
    </div>



    <!-- Jobb oldal - Bejelentkezés, Kosár, Wishlist -->
    <div class="flex items-center space-x-4">
      <button
        @click="$emit('loginpage')"
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
      >
        Bejelentkezés
      </button>
      <button
        @click="$emit('toggleCart')"
        class="text-gray-700 text-2xl"
      >
        🛒
      </button>
      <button @click="$emit('toggleWishlist')" class="mx-4 text-red-500 text-xl">
      ❤️
    </button>
    </div>
  </nav>
</template>

<script>
export default {
  name: "Navbar",
  data() {
    return {
      isLanguageMenuOpen: false,
      searchQuery: "",
    };
  },
  methods: {
    toggleLanguageMenu() {
      this.isLanguageMenuOpen = !this.isLanguageMenuOpen;
    },
    performSearch() {
      console.log("Keresési kifejezés:", this.searchQuery);
    },

    changeLanguage(locale){
      this.$i18n.locale = locale;
    },
  },
};
</script> 