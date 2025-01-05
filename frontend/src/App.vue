<template>
  <div class="min-h-screen bg-gray-100">
    <Navbar @loginpage="showModal" />

    <Modal :isOpen="isModalOpen" @close="closeModal">
      <div class="flex justify-center mb-4">
        <button @click="activeComponent = 'Login'" :class="{ 'bg-blue-500 text-white': activeComponent === 'Login', 'text-blue-500 hover:underline': activeComponent !== 'Login' }" class="p-2 rounded mr-2">Bejelentkezés</button>
        <button @click="activeComponent = 'Register'" :class="{ 'bg-blue-500 text-white': activeComponent === 'Register', 'text-blue-500 hover:underline': activeComponent !== 'Register' }" class="p-2 rounded">Regisztráció</button>
      </div>
      <component :is="activeComponent" @success="handleAuthSuccess" @switch="switchComponent" />
    </Modal>

    <router-view />
  </div>
</template>

<script>
import Modal from './components/Modal.vue';
import Login from './components/Login.vue';
import Register from './components/Register.vue';
import Navbar from './components/Navbar.vue';

export default {
  components: { Modal, Login, Register, Navbar },
  data() {
    return {
      isModalOpen: false,
      activeComponent: 'Login', // Start with login form
    };
  },
  methods: {
    showModal() {
      this.isModalOpen = true;
    },
    closeModal() {
      this.isModalOpen = false;
    },
    switchComponent(componentName) {
      this.activeComponent = componentName;
    },
    handleAuthSuccess() {
      this.closeModal();
      // Handle successful auth (e.g., redirect, update UI)
    },
  },
};
</script>

<style scoped>
.fixed {
  animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}
</style>