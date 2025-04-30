<template>
  <BaseLayout>
    <div class="flex flex-col items-center min-h-screen bg-amber-50 p-6">
      <!-- Üzenetek -->
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

      <!-- Megrendelések -->
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

      <!-- Termék feltöltés -->
      <div class="bg-yellow-50 p-10 rounded-sm shadow-xl border-4 border-double border-yellow-700 max-w-3xl w-full mb-10">
        <h2 class="text-3xl font-serif font-bold text-center text-yellow-900 mb-8 tracking-wide">
          Új termék feltöltése
        </h2>
        <form @submit.prevent="submitProduct">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block font-semibold text-yellow-800 mb-1">Név (HU)</label>
              <input v-model="product.name_hu" type="text" required class="input-field" />
            </div>
            <div>
              <label class="block font-semibold text-yellow-800 mb-1">Név (EN)</label>
              <input v-model="product.name_en" type="text" required class="input-field" />
            </div>
            <div>
              <label class="block font-semibold text-yellow-800 mb-1">Anyag (HU)</label>
              <input v-model="product.material_hu" type="text" required class="input-field" />
            </div>
            <div>
              <label class="block font-semibold text-yellow-800 mb-1">Anyag (EN)</label>
              <input v-model="product.material_en" type="text" required class="input-field" />
            </div>
            <div class="md:col-span-2">
              <label class="block font-semibold text-yellow-800 mb-1">Leírás (HU)</label>
              <textarea v-model="product.description_hu" class="input-field"></textarea>
            </div>
            <div class="md:col-span-2">
              <label class="block font-semibold text-yellow-800 mb-1">Leírás (EN)</label>
              <textarea v-model="product.description_en" class="input-field"></textarea>
            </div>
            <div>
              <label class="block font-semibold text-yellow-800 mb-1">Ár (Ft)</label>
              <input v-model.number="product.price_hu" type="number" step="0.01" required class="input-field" />
            </div>
            <div>
              <label class="block font-semibold text-yellow-800 mb-1">Ár (EN)</label>
              <input v-model.number="product.price_en" type="number" step="0.01" required class="input-field" />
            </div>
            <div>
              <label class="block font-semibold text-yellow-800 mb-1">Kategória (HU)</label>
              <input v-model="product.category_hu" type="text" class="input-field" />
            </div>
            <div>
              <label class="block font-semibold text-yellow-800 mb-1">Kategória (EN)</label>
              <input v-model="product.category_en" type="text" class="input-field" />
            </div>
            <div>
              <label class="block font-semibold text-yellow-800 mb-1">Raktárkészlet</label>
              <input v-model.number="product.stock" type="number" min="0" class="input-field" />
            </div>
            <div class="md:col-span-2">
              <label class="block font-semibold text-yellow-800 mb-1">Kép (base64, csak adatbázisban tárolva)</label>
              <input type="file" accept="image/*" @change="handleFileUpload" class="input-field" />
              <div v-if="product.image_url" class="mt-2">
                <img :src="product.image_url" alt="Előnézet" class="max-h-32 rounded shadow border border-yellow-700" />
              </div>
            </div>
          </div>
          <div v-if="successMessage" class="mt-6 p-4 bg-green-100 text-green-700 rounded-lg shadow">
            {{ successMessage }}
          </div>
          <div v-if="errorMessage" class="mt-6 p-4 bg-red-100 text-red-700 rounded-lg shadow">
            {{ errorMessage }}
          </div>
          <div class="mt-6 flex flex-col space-y-4">
            <button type="submit" class="w-full bg-yellow-700 text-white py-3 rounded-xl hover:bg-yellow-900 transition">
              Feltöltés
            </button>
          </div>
        </form>
      </div>
    </div>
  </BaseLayout>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
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
  } catch (error) {
    alert('Nem sikerült frissíteni a rendelés állapotát!');
  }
}

// ----- TERMÉK FELTÖLTÉS -----
const product = reactive({
  name_hu: '',
  name_en: '',
  material_hu: '',
  material_en: '',
  description_hu: '',
  description_en: '',
  price_hu: null,
  price_en: null,
  image_url: '',
  stock: 0,
  category_hu: '',
  category_en: ''
})

const successMessage = ref('')
const errorMessage = ref('')

const handleFileUpload = (event) => {
  const file = event.target.files[0]
  if (!file) return
  const reader = new FileReader()
  reader.onload = (e) => {
    product.image_url = e.target.result
  }
  reader.readAsDataURL(file)
}

const submitProduct = async () => {
  try {
    // Csak a base64 rész kell, ne legyen benne a "data:image/jpeg;base64," prefix
    if (product.image_url && product.image_url.startsWith('data:')) {
      product.image_url = product.image_url.split(',')[1]
    }
    await http.post('/products', product)
    successMessage.value = 'Termék sikeresen feltöltve!'
    errorMessage.value = ''
    // reset
    Object.keys(product).forEach(key => {
      if (typeof product[key] === 'string') product[key] = ''
      if (typeof product[key] === 'number') product[key] = 0
    })
  } catch (error) {
    successMessage.value = ''
    errorMessage.value = 'Hiba történt a termék feltöltésekor.'
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