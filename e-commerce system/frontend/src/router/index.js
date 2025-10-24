import { createRouter, createWebHistory } from 'vue-router'
import Login from '../components/Login.vue'
import Home from '../components/Home.vue'

const routes = [
  { path: '/login', name: 'Login', component: Login },
  { path: '/', name: 'Home', component: Home },
  { path: '/cart', name: 'Cart', component: () => import('../components/Cart.vue') },
  { path: '/checkout', name: 'Checkout', component: () => import('../components/Checkout.vue') },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
