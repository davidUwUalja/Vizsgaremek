<template>
  <div v-if="isOpen" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="relative bg-yellow-50 p-8 rounded-sm shadow-2xl border-4 border-double border-yellow-700 w-96">

      <button @click="closeModal" class="absolute top-2 right-2 text-yellow-800 text-3xl hover:text-yellow-900">
        &times;
      </button>

      <h2 class="text-3xl font-serif font-bold mb-6 text-yellow-900 text-center">
        {{ isLogin ? 'Bejelentkezés' : 'Regisztráció' }}
      </h2>

      <form @submit.prevent="isLogin ? login() : register()">
        <div v-if="!isLogin" class="mb-4">
          <label class="block text-sm text-yellow-800 font-serif mb-1">Név</label>
          <input
            type="text"
            v-model="name"
            class="w-full p-2 border-2 border-yellow-700 rounded-sm bg-yellow-50 text-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-700"
            required
          />
        </div>

        <div class="mb-4">
          <label class="block text-sm text-yellow-800 font-serif mb-1">E-mail</label>
          <input
            type="email"
            v-model="email"
            class="w-full p-2 border-2 border-yellow-700 rounded-sm bg-yellow-50 text-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-700"
            required
          />
        </div>

        <div class="mb-4">
          <label class="block text-sm text-yellow-800 font-serif mb-1">Jelszó</label>
          <input
            type="password"
            v-model="password"
            class="w-full p-2 border-2 border-yellow-700 rounded-sm bg-yellow-50 text-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-700"
            required
          />
        </div>

        <div v-if="!isLogin" class="mb-4">
          <label class="block text-sm text-yellow-800 font-serif mb-1">Jelszó megerősítése</label>
          <input
            type="password"
            v-model="password_confirmation"
            class="w-full p-2 border-2 border-yellow-700 rounded-sm bg-yellow-50 text-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-700"
            required
          />
        </div>

        <button type="submit" class="w-full mt-6 bg-yellow-700 text-yellow-50 font-serif font-semibold p-2 rounded-sm border-2 border-yellow-800 shadow-md hover:bg-yellow-900 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
          {{ isLogin ? 'Bejelentkezés' : 'Regisztráció' }}
        </button>
      </form>

      <button @click="toggleMode" class="mt-6 text-yellow-800 font-serif underline w-full text-center block hover:text-yellow-900 transition">
        {{ isLogin ? 'Nincs még fiókod? Regisztrálj!' : 'Már van fiókod? Jelentkezz be!' }}
      </button>

    </div>
  </div>
</template>

<script>
import { http } from "@utils/http";
import { useUserStore } from "@stores/UserDatasStore.mjs";

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
        const response = await http.post("/login", {
          email: this.email,
          password: this.password,
        });
        localStorage.setItem("token", response.data.data.token);

        const userStore = useUserStore();
        await userStore.fetchUser();

        this.closeModal();
        window.location.reload();
      } catch (error) {
        alert("Hibás bejelentkezési adatok!");
      }
    },
    async register() {
      try {
        const response = await http.post("/register", {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation,
        });

        let token = response.data.token || (response.data.data && response.data.data.token);
        if (token) {
          localStorage.setItem("token", token);

          const userStore = useUserStore();
          await userStore.fetchUser();

          this.closeModal();
          window.location.reload();
        } else {
          try {
            const loginResponse = await http.post("/login", {
              email: this.email,
              password: this.password,
            });
            const loginToken = loginResponse.data.token || (loginResponse.data.data && loginResponse.data.data.token);
            if (loginToken) {
              localStorage.setItem("token", loginToken);

              const userStore = useUserStore();
              await userStore.fetchUser();

              this.closeModal();
              window.location.reload();
            } else {
              alert("Regisztráció sikeres, de nem sikerült automatikusan belépni!");
            }
          } catch (loginError) {
            alert("Regisztráció sikerült, de a belépés nem! Próbálj meg belépni manuálisan.");
          }
        }
      } catch (error) {
        if (error.response && error.response.data && error.response.data.errors) {
          const errors = error.response.data.errors;
          alert(Object.values(errors).flat().join("\n"));
        } else {
          alert("Hiba történt a regisztráció során.");
        }
      }
    },
    toggleMode() {
      this.isLogin = !this.isLogin;
    },
  },
};
</script>
