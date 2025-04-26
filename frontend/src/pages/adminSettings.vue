<template>
  <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    <div class="p-8">

      <!-- Üzenetek blokk -->
      <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-xl p-8 mb-8">
        <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-6">
          Beérkezett üzenetek
        </h1>
        <div v-if="isLoadingContacts" class="text-center py-4 text-gray-600 dark:text-gray-300">
          Üzenetek betöltése...
        </div>
        <div v-else>
          <div v-if="contacts.length === 0" class="text-center text-gray-600 dark:text-gray-300">
            Nincs új üzenet.
          </div>
          <div v-else class="space-y-4">
            <div
              v-for="contact in contacts"
              :key="contact.id"
              class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm bg-gray-50 dark:bg-gray-700"
            >
              <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
                  {{ contact.name }}
                </h2>
                <span class="text-sm text-gray-500 dark:text-gray-300">
                  {{ formatDate(contact.created_at) }}
                </span>
              </div>
              <p class="mt-2 text-gray-700 dark:text-gray-200">
                <strong>Email:</strong> {{ contact.email }}
              </p>
              <p class="mt-2 text-gray-700 dark:text-gray-200">
                {{ contact.message }}
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Termék feltöltési blokk -->
      <div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-xl p-8">
        <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-6">
          Antik tárgy feltöltése
        </h1>

        <form @submit.prevent="submitProduct">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block font-semibold text-gray-700 dark:text-gray-200">Név (HU)</label>
              <input v-model="product.name_hu" type="text" required class="input-field" />
            </div>
            <div>
              <label class="block font-semibold text-gray-700 dark:text-gray-200">Név (EN)</label>
              <input v-model="product.name_en" type="text" required class="input-field" />
            </div>
            <div>
              <label class="block font-semibold text-gray-700 dark:text-gray-200">Anyag (HU)</label>
              <input v-model="product.material_hu" type="text" required class="input-field" />
            </div>
            <div>
              <label class="block font-semibold text-gray-700 dark:text-gray-200">Anyag (EN)</label>
              <input v-model="product.material_en" type="text" required class="input-field" />
            </div>
            <div class="md:col-span-2">
              <label class="block font-semibold text-gray-700 dark:text-gray-200">Leírás (HU)</label>
              <textarea v-model="product.description_hu" class="input-field"></textarea>
            </div>
            <div class="md:col-span-2">
              <label class="block font-semibold text-gray-700 dark:text-gray-200">Leírás (EN)</label>
              <textarea v-model="product.description_en" class="input-field"></textarea>
            </div>
            <div>
              <label class="block font-semibold text-gray-700 dark:text-gray-200">Ár (Ft)</label>
              <input v-model.number="product.price_hu" type="number" step="0.01" required class="input-field" />
            </div>
            <div>
              <label class="block font-semibold text-gray-700 dark:text-gray-200">Ár (EN)</label>
              <input v-model.number="product.price_en" type="number" step="0.01" required class="input-field" />
            </div>
            <div>
              <label class="block font-semibold text-gray-700 dark:text-gray-200">Kategória (HU)</label>
              <input v-model="product.category_hu" type="text" class="input-field" />
            </div>
            <div>
              <label class="block font-semibold text-gray-700 dark:text-gray-200">Kategória (EN)</label>
              <input v-model="product.category_en" type="text" class="input-field" />
            </div>
            <div>
              <label class="block font-semibold text-gray-700 dark:text-gray-200">Raktárkészlet</label>
              <input v-model.number="product.stock" type="number" min="0" class="input-field" />
            </div>
            <div class="md:col-span-2">
              <label class="block font-semibold text-gray-700 dark:text-gray-200">Kép</label>
              <input type="file" accept="image/*" @change="handleFileUpload" class="input-field" />
            </div>
          </div>

          <div v-if="successMessage" class="mt-6 p-4 bg-green-100 text-green-700 rounded-lg shadow">
            {{ successMessage }}
          </div>
          <div v-if="errorMessage" class="mt-6 p-4 bg-red-100 text-red-700 rounded-lg shadow">
            {{ errorMessage }}
          </div>

          <div class="mt-6 flex flex-col space-y-4">
            <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-xl hover:bg-indigo-700 transition">
              Feltöltés
            </button>
            <button @click.prevent="logout" class="w-full bg-red-600 text-white font-semibold py-3 rounded-xl hover:bg-red-700 transition">
              Kijelentkezés
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import { useUserStore } from '@stores/UserDatasStore.mjs'
import { useRouter } from 'vue-router'
import { http } from '@utils/http'

const userStore = useUserStore()
const router = useRouter()

// Termékfeltöltés adatmodel
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

// File feltöltés kezelése
const handleFileUpload = (event) => {
  const file = event.target.files[0]
  const reader = new FileReader()
  reader.onload = (e) => {
    product.image_url = e.target.result
  }
  reader.readAsDataURL(file)
}

const submitProduct = async () => {
  try {
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

const logout = () => {
  userStore.logout()
  router.push('/login')
}

// Üzenetek lekérése
const contacts = ref([])
const isLoadingContacts = ref(true)

const fetchContacts = async () => {
  try {
    const response = await http.get('/contact')
    contacts.value = response.data
  } catch (error) {
    console.error('Hiba az üzenetek lekérésekor:', error)
  } finally {
    isLoadingContacts.value = false
  }
}

const formatDate = (dateString) => {
  const options = { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' }
  return new Date(dateString).toLocaleString(undefined, options)
}

onMounted(() => {
  fetchContacts()
})
</script>

<route lang="json">
{
  "name": "adminSettings",
  "meta": {
    "title": "Admin beállítások"
  }
}
</route>
