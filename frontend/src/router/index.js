import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import ConfirmView from '@/views/ConfirmView.vue';

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/registration',
    name: 'registration',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/RegistrationView.vue')
  },
  {
    path: '/signup-confirm',
    name: 'confirm',
    component: ConfirmView,
    props: route => ({ query: route.query })
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
