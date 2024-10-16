import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import ConfirmView from '@/views/ConfirmView.vue';
import LoginView from '@/views/LoginView.vue';

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
  { path: '/login', name: 'login', component: LoginView },
  {
    path: '/profile',
    name: 'profile',
    meta: {
      requiresAuth: true,
      title: 'Профиль'
    },
    component: () => import('../views/ProfileView.vue')
  },
  {
    path: '/forgot-password',
    name: 'ForgotPassword',
    component: () => import('../views/ForgotPasswordView.vue')
  },
  {
    path: '/reset-password',
    name: 'ResetPassword',
    component: () => import('../views/ResetPasswordView.vue')
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
