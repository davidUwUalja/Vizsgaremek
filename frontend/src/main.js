import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { router } from '@/router/index.js'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
import { plugin, defaultConfig } from '@formkit/vue'
import config from '../formkit.config.js'
import i18n from './i18n.js'; // Import the merged i18n instance

import App from '@/App.vue'

import '@assets/app.scss'

const app = createApp(App)

const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)

app.use(router)
app.use(plugin, defaultConfig(config))
app.use(pinia)
app.use(i18n); // Use the merged i18n instance

app.mount('#app')