import { createRouter, createWebHistory } from 'vue-router'
import authRoutes from './auth';
import guestRoutes from './guest';
import { useAuthStore } from '@/stores/auth';

const routes = [
  ...guestRoutes,
  ...authRoutes
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});



// router.beforeEach((to, from, next) => {
//   const authStore = useAuthStore();
//   const isAuthenticated = authStore.user;

//   console.log('sAuthenticated', isAuthenticated)

// });



export default router
