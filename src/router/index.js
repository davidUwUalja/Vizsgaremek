import { createRouter, createWebHistory } from 'vue-router';
import Home from '../components/Home.vue';

import Contact from '../components/Contact.vue';
import ProductList from '../components/ProductList.vue';

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
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
