<template>
  <nav class="bg-yellow-50 shadow-lg p-4 flex items-center justify-between border-b-4 border-yellow-700">
    <!-- Bal oldal - Nyelvválasztó + Keresés -->
    <div class="flex items-center space-x-6">
      <!-- Nyelvváltó -->
      <div class="relative">
        <button
          @click="toggleLanguageMenu"
          class="text-yellow-800 hover:bg-yellow-200 px-4 py-2 rounded-sm font-serif border border-yellow-700 shadow-sm hover:shadow-md transition-all duration-300"
        >
          🌐 {{ $t("language") }}
        </button>
        <div v-if="isLanguageMenuOpen" class="absolute bg-white shadow-lg rounded-sm mt-2 w-32 z-10 border border-yellow-700">
          <ul>
            <li @click="changeLanguage('hu')" class="p-2 hover:bg-yellow-100 cursor-pointer text-yellow-800">Magyar</li>
            <li @click="changeLanguage('en')" class="p-2 hover:bg-yellow-100 cursor-pointer text-yellow-800">English</li>
          </ul>
        </div>
      </div>

      <!-- Keresőmező -->
      <div class="flex items-center border-2 border-yellow-700 rounded-sm px-2 bg-white shadow-sm">
        <input
          type="text"
          :placeholder="$t('searchPlaceholder')"
          class="outline-none text-yellow-900 px-2 py-1 w-48 bg-transparent font-serif placeholder-yellow-600"
          @keyup.enter="performSearch"
          v-model="searchQuery"
        />
        <button @click="performSearch" class="text-yellow-800 hover:text-yellow-900 transition-colors duration-300 ml-2 text-xl">
          🔍
        </button>
      </div>
    </div>

    <!-- Középső rész - Navigációs linkek -->
    <div class="flex items-center space-x-6 font-serif">
      <router-link
        to="/landing"
        class="text-yellow-800 px-3 py-2 rounded-sm hover:bg-yellow-200 transition-all duration-300 shadow-sm hover:shadow-md"
      >
        {{ $t('home') }}
      </router-link>
      <router-link
        to="/products"
        class="text-yellow-800 px-3 py-2 rounded-sm hover:bg-yellow-200 transition-all duration-300 shadow-sm hover:shadow-md"
      >
        {{ $t('products') }}
      </router-link>
      <router-link
        to="/blogpage"
        class="text-yellow-800 px-3 py-2 rounded-sm hover:bg-yellow-200 transition-all duration-300 shadow-sm hover:shadow-md"
      >
        {{ $t('blog') }}
      </router-link>
      <router-link
        to="/contact"
        class="text-yellow-800 px-3 py-2 rounded-sm hover:bg-yellow-200 transition-all duration-300 shadow-sm hover:shadow-md"
      >
        {{ $t('contact') }}
      </router-link>
    </div>

    <!-- Jobb oldal - Autentikáció & Ikonok -->
    <div class="flex items-center space-x-4">
      <button
        v-if="!isAuthenticated"
        @click="openModal"
        class="bg-yellow-700 text-yellow-50 px-4 py-2 rounded-sm font-serif hover:bg-yellow-900 transition-all duration-300 shadow-md border border-yellow-800"
      >
        {{ $t('login') }}
      </button>

      <!-- Profilmenü -->
      <div v-else class="relative">
        <button @click="toggleProfileMenu" class="text-yellow-800 text-xl hover:scale-110 transition-transform duration-300">👤</button>
        <div v-if="isProfileMenuOpen" class="absolute right-0 bg-white shadow-lg rounded-sm mt-2 w-40 z-10 border border-yellow-700">
          <ul>
            <li class="p-2 hover:bg-yellow-100 cursor-pointer text-yellow-800">{{ $t('settings') }}</li>
            <li class="p-2 hover:bg-yellow-100 cursor-pointer text-yellow-800">{{ $t('accounts') }}</li>
            <li @click="$emit('logout')" class="p-2 hover:bg-red-100 cursor-pointer text-red-600 font-semibold">{{ $t('logout') }}</li>
          </ul>
        </div>
      </div>

      <!-- Kosár & Wishlist -->
      <button @click="$emit('toggleCart')" class="text-yellow-800 text-2xl hover:scale-110 transition-transform duration-300">🛒</button>
      <button @click="$emit('toggleWishlist')" class="text-red-500 text-xl hover:scale-110 transition-transform duration-300">❤️</button>
    </div>

    <!-- Bejelentkezési Modal -->
    <AuthModal :isOpen="isModalOpen" :closeModal="closeModal" />
  </nav>
</template>

<script>
import AuthModal from "../components/AuthModal.vue";

export default {
  name: "Navbar",
  components: { AuthModal },
  props: {
    isAuthenticated: Boolean,
  },
  data() {
    return {
      isLanguageMenuOpen: false,
      isProfileMenuOpen: false,
      isModalOpen: false,
      searchQuery: "",
    };
  },
  methods: {
    toggleLanguageMenu() {
      this.isLanguageMenuOpen = !this.isLanguageMenuOpen;
    },
    toggleProfileMenu() {
      this.isProfileMenuOpen = !this.isProfileMenuOpen;
    },
    performSearch() {
      console.log("Keresési kifejezés:", this.searchQuery);
    },
    changeLanguage(locale) {
      this.$i18n.locale = locale;
    },
    openModal() {
      this.isModalOpen = true;
    },
    closeModal() {
      this.isModalOpen = false;
    },
  },
};
</script>
