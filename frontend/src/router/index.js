import { createRouter, createWebHistory } from 'vue-router';
import Login from '../components/Login.vue';
import Register from '../components/Register.vue';
import Landing from '../pages/Landing.vue';
import Products from '../pages/ProductList.vue';
import Contact from '../pages/Contact.vue';
import Settings from '../pages/Settings.vue';

const routes = [
  { path: '/', redirect: '/landing' },
  { path: '/landing', component: Landing },
  { path: '/products', component: Products },
  { path: '/contact', component: Contact },
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { path: '/settings', component: Settings },
];

export const router = createRouter({
  history: createWebHistory(),
  routes,
});