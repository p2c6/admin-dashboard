import { createRouter, createWebHistory } from 'vue-router'
import authRoutes from './auth';
import guestRoutes from './guest';

const routes = [
  ...guestRoutes,
  ...authRoutes
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

// router.beforeEach((to, from, next) => {
  
//   const isAuthenticated = !!localStorage.getItem('authToken'); // Example auth check
//   if (to.meta.requiresAuth && !isAuthenticated) {
//     next('/login');
//   } else {
//     next();
//   }
// });

export default router
