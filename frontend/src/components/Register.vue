<template>
  <div>
    <h2 class="text-2xl font-semibold text-center mb-4">Regisztráció</h2>
    <form @submit.prevent="registerUser">
      <input type="text" v-model="name" placeholder="Név" class="border rounded p-2 mb-2 w-full">
      <input type="email" v-model="email" placeholder="Email" class="border rounded p-2 mb-2 w-full">
      <input type="password" v-model="password" placeholder="Jelszó" class="border rounded p-2 mb-4 w-full">
      <button type="submit" class="bg-blue-500 text-white p-2 rounded w-full">Regisztráció</button>
      <div v-if="error" class="text-red-500 mt-2">{{ error }}</div>
    </form>
    <button @click="$emit('switch', 'login')" class="mt-2 text-blue-500 underline">Vissza a bejelentkezéshez</button>
  </div>
</template>

<script>
import { ref } from 'vue';

export default {
  setup(props, { emit }){
      const name = ref('');
      const email = ref('');
      const password = ref('');
      const error = ref(null)

      const registerUser = async () => {
          error.value = null;
          try {
              const response = await fetch('http://backend.vm1.test/api/register', {
                  method: 'POST',
                  headers: {
                      'Content-Type': 'application/json',
                  },
                  body: JSON.stringify({
                      name: name.value,
                      email: email.value,
                      password: password.value,
                  }),
              });
              const data = await response.json();

              if (response.ok) {
                  emit('success');
              } else {
                  error.value = data.error || 'Sikertelen regisztráció.';
              }
          } catch (err) {
              error.value = 'Hiba a regisztráció során.';
          }
      };

      return { name, email, password, registerUser, error };
  }
};
</script>