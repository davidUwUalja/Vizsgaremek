<template>
  <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-semibold text-black text-center mb-4">Felhasználók listája</h2>
    
    <div v-if="loading" class="text-gray-700 text-center">Felhasználók betöltése...</div>
    
    <table v-else class="w-full border-collapse border border-gray-300 text-gray-700">
      <thead class="bg-gray-200">
        <tr>
          <th class="p-3 border border-gray-300">Név</th>
          <th class="p-3 border border-gray-300">E-mail</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td class="p-3 border border-gray-300">{{ user.name }}</td>
          <td class="p-3 border border-gray-300">{{ user.email }}</td>
        </tr>
      </tbody>
    </table>

    <div v-if="error" class="text-red-500 text-center mt-4">{{ error }}</div>
  </div>
</template>

<script>
import { http } from '@utils/http.mjs';

export default {
  data() {
    return {
      users: [],
      loading: true,
      error: null,
    };
  },
  methods: {
    fetchUsers() {
      http.get('/users')
        .then(response => {
          this.users = response.data;
          this.loading = false; 
        })
        .catch(error => {
          this.error = 'Hiba a felhasználók lekérése közben'; 
          this.loading = false;
        });
    },
  },
  created() {
    this.fetchUsers();
  },
};
</script>
