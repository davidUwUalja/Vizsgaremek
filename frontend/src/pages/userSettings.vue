<template>
  <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-semibold text-black text-center mb-6">Felhasználói adatok</h2>

    <table class="w-full border-collapse border border-gray-300 text-gray-700 mb-8">
      <tbody>
        <tr class="bg-gray-100">
          <td class="p-3 font-medium border border-gray-300">Név:</td>
          <td class="p-3 border border-gray-300">{{ user?.name }}</td>
        </tr>
        <tr>
          <td class="p-3 font-medium border border-gray-300">E-mail:</td>
          <td class="p-3 border border-gray-300">{{ user?.email }}</td>
        </tr>
        <tr>
          <td class="p-3 font-medium border border-gray-300">Szerepkör:</td>
          <td class="p-3 border border-gray-300">{{ user?.role }}</td>
        </tr>
      </tbody>
    </table>

    <div v-if="user?.orders?.length > 0">
      <h3 class="text-xl font-semibold text-black mb-4">Korábbi vagy folyamatban lévő vásárlások</h3>
      <table class="w-full border-collapse border border-gray-300 text-gray-700">
        <thead class="bg-gray-100">
          <tr>
            <th class="p-3 border border-gray-300 text-left">Rendelés azonosító</th>
            <th class="p-3 border border-gray-300 text-left">Állapot</th>
            <th class="p-3 border border-gray-300 text-left">Összeg</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="order in user.orders" :key="order.id">
            <td class="p-3 border border-gray-300">{{ order.id }}</td>
            <td class="p-3 border border-gray-300">{{ order.status }}</td>
            <td class="p-3 border border-gray-300">{{ order.total }} Ft</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-else class="text-center text-gray-500 mt-6">
      Jelenleg nincs korábbi vásárlásod.
    </div>
  </div>
</template>

<script>
import { useUserStore } from "@stores/UserDatasStore.mjs";
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

<route lang="json">
{
  "name": "userSettings",
  "meta": {
    "title": "User beállítások"
  }
}
</route>
