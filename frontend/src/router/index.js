import { createRouter, createWebHistory } from 'vue-router';
import Home from '../components/Home.vue';
import Contact from '../components/Contact.vue';
import ProductList from '../components/ProductList.vue';
import Login from '../components/Login.vue';
import Register from '../components/Register.vue';

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home,
    },
    {
        path: '/products',
        name: 'Products',
        component: ProductList,
    },
    {
        path: '/contact',
        name: 'Contact',
        component: Contact,
    },
    {
        path: '/login',
        name: 'Login',
        components: { default: Login, 'login-area': Login }, // Named view for modal
        meta: { guest: true }
    },
    {
        path: '/register',
        name: 'Register',
        components: { default: Register, 'login-area': Register }, // Named view for modal
        meta: { guest: true }
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;