<template>
  <BaseLayout>
    <div class="flex justify-center items-center min-h-screen bg-amber-50 p-6">
      <div class="bg-yellow-50 p-10 rounded-sm shadow-xl border-4 border-double border-yellow-700 max-w-4xl w-full">

        <h2 class="text-3xl font-serif font-bold text-center text-yellow-900 mb-8 tracking-wide">
          Felhasználói adatok
        </h2>

        <table class="w-full border-collapse border border-yellow-700 text-yellow-900 mb-10 bg-white rounded">
          <tbody>
            <tr class="bg-yellow-100">
              <td class="p-3 font-semibold border border-yellow-700 w-1/3">Név:</td>
              <td class="p-3 border border-yellow-700">{{ user?.name }}</td>
            </tr>
            <tr>
              <td class="p-3 font-semibold border border-yellow-700">E-mail:</td>
              <td class="p-3 border border-yellow-700">{{ user?.email }}</td>
            </tr>
            <tr>
              <td class="p-3 font-semibold border border-yellow-700">Szerepkör:</td>
              <td class="p-3 border border-yellow-700">{{ user?.role }}</td>
            </tr>
          </tbody>
        </table>

        <div v-if="filteredOrders.length > 0">
          <h3 class="text-2xl font-serif font-semibold text-yellow-900 mb-6">Rendeléseid</h3>
          <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-yellow-700 text-yellow-900 bg-white rounded shadow">
              <thead class="bg-yellow-100">
                <tr>
                  <th class="p-3 border border-yellow-700 text-left">Időpont</th>
                  <th class="p-3 border border-yellow-700 text-left">Állapot</th>
                  <th class="p-3 border border-yellow-700 text-left">Összeg</th>
                  <th class="p-3 border border-yellow-700 text-left">Szállítási cím</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="order in filteredOrders" :key="order.id" class="hover:bg-yellow-50 transition">
                  <td class="p-3 border border-yellow-700">{{ formatDate(order.created_at) }}</td>
                  <td class="p-3 border border-yellow-700">{{ order.status }}</td>
                  <td class="p-3 border border-yellow-700">{{ order.total_price }} Ft</td>
                  <td class="p-3 border border-yellow-700">{{ order.address }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div v-else class="text-center text-yellow-800 mt-10 text-lg font-serif">
          Jelenleg nincs korábbi vásárlásod.
        </div>
      </div>
    </div>
  </BaseLayout>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import { useUserStore } from "@stores/UserDatasStore.mjs";
import { useRouter } from "vue-router";
import BaseLayout from "@layouts/BaseLayout.vue";
import { http } from "@utils/http";

const userStore = useUserStore();
const router = useRouter();

const user = userStore.user;
const allOrders = ref([]);

// --- Védelem: csak customer léphet be ---
if (!user || user.role !== 'customer') {
  router.replace({ path: '/', query: { showAuth: '1' } });
}

onMounted(async () => {
  // Frissítsd a user adatokat, ha kell
  await userStore.fetchUser();
  // Lekérjük az összes rendelést
  const resp = await http.get('/orders');
  allOrders.value = resp.data;
});

const filteredOrders = computed(() => {
  if (!user) return [];
  // Csak azokat az order-eket mutatjuk, ahol a user email ÉS név egyezik
  return allOrders.value.filter(
    order =>
      order.email === user.email &&
      order.name === user.name
  );
});

const formatDate = (dateString) => {
  if (!dateString) return '';
  const options = { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
  return new Date(dateString).toLocaleString('hu-HU', options);
};
</script>
