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
  const isLoggedIn = !!userStore.user
  const userRole = userStore.user?.role

  if (to.meta.requiresAuth) {
    if (!isLoggedIn) {
      // Főoldalra dobjuk vissza, AuthModal-t ott jelenítjük meg
      return next({ path: '/', query: { showAuth: '1' } })
    }
    if (to.meta.role && userRole !== to.meta.role) {
      return next('/')
    }
  }
  next()
})