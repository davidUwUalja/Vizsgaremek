<template>
  <BaseLayout>
    <div class="flex flex-col items-center min-h-screen bg-amber-50 p-6">
      <div class="bg-yellow-50 p-10 rounded-sm shadow-xl border-4 border-double border-yellow-700 max-w-4xl w-full mb-10">
        <h2 class="text-3xl font-serif font-bold text-center text-yellow-900 mb-8 tracking-wide">
          Admin – Beérkezett üzenetek
        </h2>
        <div v-if="isLoadingContacts" class="text-center py-4 text-yellow-800">
          Üzenetek betöltése...
        </div>
        <div v-else>
          <div v-if="contacts.length === 0" class="text-center text-yellow-800">
            Nincs új üzenet.
          </div>
          <div v-else class="space-y-4">
            <div
              v-for="contact in contacts"
              :key="contact.id"
              class="p-4 border border-yellow-700 rounded bg-amber-100 shadow"
            >
              <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-yellow-900">
                  {{ contact.name }}
                </h3>
                <span class="text-sm text-yellow-700">
                  {{ formatDate(contact.created_at) }}
                </span>
              </div>
              <p class="mt-2 text-yellow-800">
                <strong>Email:</strong> {{ contact.email }}
              </p>
              <p class="mt-2 text-yellow-800">
                {{ contact.message }}
              </p>
            </div>
          </div>
        </div>
      </div>

      <div class="bg-yellow-50 p-10 rounded-sm shadow-xl border-4 border-double border-yellow-700 max-w-4xl w-full mb-10">
        <h2 class="text-3xl font-serif font-bold text-center text-yellow-900 mb-8 tracking-wide">
          Megrendelések kezelése (Admin)
        </h2>
        <div v-if="isLoadingOrders" class="text-center py-4 text-yellow-800">
          Megrendelések betöltése...
        </div>
        <div v-else>
          <div v-if="orders.length === 0" class="text-center text-yellow-800">
            Nincs megrendelés.
          </div>
          <div v-else class="overflow-x-auto">
            <table class="w-full border-collapse border border-yellow-700 text-yellow-900 bg-white rounded shadow">
              <thead class="bg-yellow-100">
                <tr>
                  <th class="p-3 border border-yellow-700 text-left">Időpont</th>
                  <th class="p-3 border border-yellow-700 text-left">Név</th>
                  <th class="p-3 border border-yellow-700 text-left">Email</th>
                  <th class="p-3 border border-yellow-700 text-left">Állapot</th>
                  <th class="p-3 border border-yellow-700 text-left">Összeg</th>
                  <th class="p-3 border border-yellow-700 text-left">Szállítási cím</th>
                  <th class="p-3 border border-yellow-700 text-left">Művelet</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="order in orders" :key="order.id" class="hover:bg-yellow-50 transition">
                  <td class="p-3 border border-yellow-700">{{ formatDate(order.created_at) }}</td>
                  <td class="p-3 border border-yellow-700">{{ order.name }}</td>
                  <td class="p-3 border border-yellow-700">{{ order.email }}</td>
                  <td class="p-3 border border-yellow-700">
                    <span
                      :class="{
                        'text-green-700 font-bold': order.status === 'completed',
                        'text-yellow-700': order.status === 'pending',
                        'text-gray-700': order.status === 'cancelled'
                      }"
                    >
                      {{ order.status }}
                    </span>
                  </td>
                  <td class="p-3 border border-yellow-700">{{ order.total_price }} Ft</td>
                  <td class="p-3 border border-yellow-700">{{ order.address }}</td>
                  <td class="p-3 border border-yellow-700">
                    <select
                      v-model="order.status"
                      @change="changeOrderStatus(order)"
                      class="border border-yellow-700 rounded px-2 py-1"
                    >
                      <option value="pending">pending</option>
                      <option value="completed">completed</option>
                      <option value="cancelled">cancelled</option>
                    </select>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </BaseLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useUserStore } from '@stores/UserDatasStore.mjs'
import { useOrderDatasStore } from '@stores/OrderDatasStore.mjs'
import { useRouter } from 'vue-router'
import { http } from '@utils/http'
import BaseLayout from '@layouts/BaseLayout.vue'

const userStore = useUserStore()
const orderStore = useOrderDatasStore()
const router = useRouter()

if (!userStore.user || userStore.user.role !== 'admin') {
  router.replace({ path: '/', query: { showAuth: '1' } })
}

const contacts = ref([])
const isLoadingContacts = ref(true)
const orders = ref([])
const isLoadingOrders = ref(true)

const fetchContacts = async () => {
  try {
    const response = await http.get('/contact')
    contacts.value = response.data.data
  } catch (error) {
    console.error('Hiba az üzenetek lekérésekor:', error)
  } finally {
    isLoadingContacts.value = false
  }
}

const fetchOrders = async () => {
  try {
    const response = await orderStore.fetchAllOrders()
    orders.value = response
  } catch (error) {
    console.error('Hiba a megrendelések lekérésekor:', error)
  } finally {
    isLoadingOrders.value = false
  }
}

const changeOrderStatus = async (order) => {
  try {
    await orderStore.updateOrderStatus(order.id, order.status)
    // A helyi orders tömb már frissül a v-model miatt
  } catch (error) {
    alert('Nem sikerült frissíteni a rendelés állapotát!');
  }
}

const formatDate = (dateString) => {
  const options = { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' }
  return new Date(dateString).toLocaleString('hu-HU', options)
}

onMounted(() => {
  fetchContacts()
  fetchOrders()
})
</script>
