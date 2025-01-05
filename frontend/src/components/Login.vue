<template>
  <div>
    <h2 class="text-2xl font-semibold text-center mb-4">Bejelentkezés</h2>
    <form @submit.prevent="loginUser">
      <input type="text" v-model="identifier" placeholder="Felhasználónév vagy email" class="border rounded p-2 mb-2 w-full">
      <input type="password" v-model="password" placeholder="Jelszó" class="border rounded p-2 mb-4 w-full">
      <button type="submit" class="bg-blue-500 text-white p-2 rounded w-full">Bejelentkezés</button>
      <div v-if="error" class="text-red-500 mt-2">{{ error }}</div>
    </form>
    <button @click="$emit('switch', 'register')" class="mt-2 text-blue-500 underline">Regisztráció</button>
  </div>
</template>

<script>
import { ref } from 'vue';
import { useRouter } from 'vue-router'; // Import for navigation

export default {
  setup(props, { emit }) {
    const identifier = ref('');
    const password = ref('');
    const error = ref(null);
    const router = useRouter(); // Get router instance

    const loginUser = async () => {
      error.value = null;
      try {
        const response = await fetch('http://backend.vm1.test/api/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            identifier: identifier.value,
            password: password.value,
          }),
        });
        const data = await response.json();

        if (response.ok) {
          localStorage.setItem('auth_token', data.token); // Store token
          emit('success'); // Emit success event
          router.push('/'); // Optional: Redirect to homepage after login
        } else {
          error.value = data.error || 'Sikertelen bejelentkezés.';
        }
      } catch (err) {
        error.value = 'Hiba a bejelentkezés során.';
      }
    };

    return { identifier, password, loginUser, error };
  },
};
</script>