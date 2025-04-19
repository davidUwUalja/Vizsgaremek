<template>
  <nav class="bg-yellow-50 shadow-lg p-4 border-b-4 border-yellow-700">
    <div class="flex items-center justify-between">
      <!-- Bal oldal: Nyelvváltó + Keresés -->
      <div class="flex items-center space-x-6">
        <!-- Nyelvváltó -->
        <div class="relative">
          <button
            @click="toggleLanguageMenu"
            class="text-yellow-800 hover:bg-yellow-200 px-4 py-2 rounded-sm font-serif border border-yellow-700 shadow-sm transition-all duration-300"
          >
            🌐 {{ $t('language') }}
          </button>
          <div
            v-if="isLanguageMenuOpen"
            class="absolute bg-white shadow-lg rounded-sm mt-2 w-32 z-10 border border-yellow-700"
          >
            <ul>
              <li @click="changeLanguage('hu')" class="p-2 hover:bg-yellow-100 cursor-pointer text-yellow-800">
                Magyar
              </li>
              <li @click="changeLanguage('en')" class="p-2 hover:bg-yellow-100 cursor-pointer text-yellow-800">
                English
              </li>
            </ul>
          </div>
        </div>

        <!-- Keresőmező -->
        <div class="flex items-center border-2 border-yellow-700 rounded-sm px-2 bg-white shadow-sm">
          <input
            v-model="searchQuery"
            @keyup.enter="performSearch"
            :placeholder="$t('searchPlaceholder')"
            class="outline-none text-yellow-900 px-2 py-1 w-32 sm:w-48 bg-transparent font-serif placeholder-yellow-600"
          />
          <button @click="performSearch" class="text-yellow-800 hover:text-yellow-900 ml-2 text-xl">🔍</button>
        </div>
      </div>

      <!-- Középső menü linkek (desktop) -->
      <div class="hidden md:flex items-center space-x-6 font-serif">
        <router-link to="/"       class="text-yellow-800 px-3 py-2 rounded-sm hover:bg-yellow-200 transition-all duration-300 shadow-sm"> {{ $t('home') }} </router-link>
        <router-link to="/productList" class="text-yellow-800 px-3 py-2 rounded-sm hover:bg-yellow-200 transition-all duration-300 shadow-sm"> {{ $t('products') }} </router-link>
        <router-link to="/blogPage"    class="text-yellow-800 px-3 py-2 rounded-sm hover:bg-yellow-200 transition-all duration-300 shadow-sm"> {{ $t('blog') }} </router-link>
        <router-link to="/contact"     class="text-yellow-800 px-3 py-2 rounded-sm hover:bg-yellow-200 transition-all duration-300 shadow-sm"> {{ $t('contact') }} </router-link>
      </div>

      <!-- Mobil hamburger -->
      <div class="md:hidden">
        <button @click="toggleMobileMenu" class="text-yellow-800 text-2xl">☰</button>
      </div>

      <!-- Jobb oldal: Auth & ikonok -->
      <div class="flex items-center space-x-4">
        <!-- Bejelentkezés gomb -->
        <button
          v-if="!isAuthenticated"
          @click="openModal"
          class="bg-yellow-700 text-yellow-50 px-4 py-2 rounded-sm font-serif hover:bg-yellow-900 transition-all duration-300 shadow-md border border-yellow-800"
        >
          {{ $t('login') }}
        </button>

        <!-- Profilmenü -->
        <div v-else class="relative">
          <button
            @click="toggleProfileMenu"
            class="text-yellow-800 text-xl hover:scale-110 transition-transform duration-300"
          >👤</button>
          <div
            v-if="isProfileMenuOpen"
            class="absolute right-0 bg-white shadow-lg rounded-sm mt-2 w-40 z-10 border border-yellow-700"
          >
            <ul>
              <li>
                <router-link :to="settingsRoute" class="block px-4 py-2 hover:bg-yellow-100">
                  {{ $t('settings') }}
                </router-link>
              </li>
              <li class="px-4 py-2 hover:bg-yellow-100">{{ $t('accounts') }}</li>
              <li @click="handleLogout" class="px-4 py-2 hover:bg-red-100 text-red-600 cursor-pointer font-semibold">
                {{ $t('logout') }}
              </li>
            </ul>
          </div>
        </div>

        <!-- Kosár és wishlist ikonok -->
        <button @click="$emit('toggleCart')"    class="text-yellow-800 text-2xl hover:scale-110 transition-transform duration-300">🛒</button>
        <button @click="$emit('toggleWishlist')" class="text-red-500 text-xl hover:scale-110 transition-transform duration-300">❤️</button>
      </div>
    </div>

    <!-- Mobil menü linkek -->
    <div v-if="isMobileMenuOpen" class="md:hidden mt-3">
      <ul class="flex flex-col space-y-2">
        <li><router-link to="/"           class="block text-yellow-800 px-3 py-2 rounded-sm hover:bg-yellow-200 shadow-sm"> {{ $t('home') }} </router-link></li>
        <li><router-link to="/productList" class="block text-yellow-800 px-3 py-2 rounded-sm hover:bg-yellow-200 shadow-sm"> {{ $t('products') }} </router-link></li>
        <li><router-link to="/blogPage"    class="block text-yellow-800 px-3 py-2 rounded-sm hover:bg-yellow-200 shadow-sm"> {{ $t('blog') }} </router-link></li>
        <li><router-link to="/contact"     class="block text-yellow-800 px-3 py-2 rounded-sm hover:bg-yellow-200 shadow-sm"> {{ $t('contact') }} </router-link></li>
      </ul>
    </div>

    <!-- Auth modal -->
    <AuthModal :isOpen="isModalOpen" :closeModal="closeModal" />
  </nav>
</template>

<script>
import AuthModal from '@/components/AuthModal.vue'
import { useUserStore } from '@/stores/UserDatasStore.mjs'
import { http } from '@utils/http'
export default {
  name: 'Navbar',
  components: { AuthModal },
  data() {
    return {
      isLanguageMenuOpen: false,
      isProfileMenuOpen:  false,
      isModalOpen:        false,
      isMobileMenuOpen:   false,
      searchQuery:        '',
    }
  },
  computed: {
    isAuthenticated() {
      return !!localStorage.getItem('token')
    },
    userStore() {
      return useUserStore()
    },
    userRole() {
      return this.userStore.user?.role || null
    },
    isAdmin() {
      return this.userRole === 'admin'
    },
    settingsRoute() {
      return this.isAdmin
        ? { name: 'adminSettings' }
        : { name: 'settings' }
    },
  },
  created() {
    if (this.isAuthenticated && !this.userStore.user) {
      // beállítjuk az axios default header-t
      http.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`
      this.userStore.fetchUser()
    }
  },
  methods: {
    toggleLanguageMenu() {
      this.isLanguageMenuOpen = !this.isLanguageMenuOpen
    },
    toggleProfileMenu() {
      this.isProfileMenuOpen = !this.isProfileMenuOpen
    },
    toggleMobileMenu() {
      this.isMobileMenuOpen = !this.isMobileMenuOpen
    },
    performSearch() {
      console.log('Keresés:', this.searchQuery)
    },
    changeLanguage(lang) {
      this.$i18n.locale = lang
      this.isLanguageMenuOpen = false
    },
    openModal() {
      this.isModalOpen = true
    },
    closeModal() {
      this.isModalOpen = false
    },
    handleLogout() {
      localStorage.removeItem('token')
      this.userStore.$reset()
      this.$router.push({ name: 'login' })
    },
  },
}
</script>
