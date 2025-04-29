import { createRouter, createWebHistory } from 'vue-router'
import { routes } from 'vue-router/auto-routes'
import { useUserStore } from '@stores/UserDatasStore.mjs'

export const router = createRouter({
  history: createWebHistory(),
  linkActiveClass: 'active',
  routes
})

router.beforeEach((to, from, next) => {
  const userStore = useUserStore()
  console.log('[ROUTER GUARD] from', from.fullPath, '→ to', to.fullPath, '   userStore.user=', userStore.user)
  next()
})