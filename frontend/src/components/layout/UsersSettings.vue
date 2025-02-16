<template>
  <div class="max-w-lg mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-semibold text-black text-center mb-4">Felhasználói adatok</h2>
    
    <table class="w-full border-collapse border border-gray-300 text-gray-700">
      <tbody>
        <tr class="bg-gray-100">
          <td class="p-3 font-medium border border-gray-300">Név:</td>
          <td class="p-3 border border-gray-300">{{ user?.name }}</td>
        </tr>
        <tr>
          <td class="p-3 font-medium border border-gray-300">E-mail:</td>
          <td class="p-3 border border-gray-300">{{ user?.email }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { useUserStore } from "@/stores/UserDatasStore.mjs";
import { onMounted } from "vue";
import { storeToRefs } from "pinia";

export default {
  setup() {
    const userStore = useUserStore();
    const { getUserData } = storeToRefs(userStore);

    onMounted(() => {
      userStore.fetchUser();
    });

    return {
      user: getUserData,
    };
  },
};
</script>