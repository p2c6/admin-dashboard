import { createRouter, createWebHistory } from 'vue-router';
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

router.beforeEach(async (to, from, next) => {
  const authStore = useAuthStore();

  await authStore.getUser();

  if (authStore.user && to.name === 'login') {
    return next({ name: 'home' });
  }

  if (to.meta.requiresAuth && !authStore.user) {
    return next({ name: 'login' });
  }

  next();
});

export default router;
