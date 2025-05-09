import { defineStore } from "pinia";
import { http } from "@utils/http.mjs";

export const useUserStore = defineStore("user", {
  state: () => ({
    user: null,
  }),
  persist: true,
  getters: {
    getUserData(state) {
      return state.user ? { ...state.user } : null;
    },
  },
  actions: {
    async fetchUser() {
      const token = localStorage.getItem("token");
      if (!token) return;

      try {
        const response = await http.get("/user", {
          headers: { Authorization: `Bearer ${token}` },
        });
        this.user = response.data;
      } catch (error) {
        console.error("Felhasználó lekérése sikertelen", error);
        this.logout();
      }
    },
    logout() {
      this.user = null;
      localStorage.removeItem("token");
    },
  },
});
