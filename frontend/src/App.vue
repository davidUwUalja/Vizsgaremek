<template>
  <div>
    <Navbar :isAuthenticated="isAuthenticated" @logout="logout" />
    <router-view /> <!-- Itt töltődnek be az oldalak -->
  </div>
</template>

<script>
import Navbar from "./components/Navbar.vue";

export default {
  components: { Navbar },
  data() {
    return {
      isAuthenticated: !!localStorage.getItem("token"),
    };
  },
  methods: {
    logout() {
      localStorage.removeItem("token");
      this.isAuthenticated = false;
      this.$router.push("/landing"); // Maradunk a Landing oldalon
    },
  },
};
</script>
