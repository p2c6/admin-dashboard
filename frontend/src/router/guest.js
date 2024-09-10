import GuestLayout from '@/components/layouts/GuestLayout.vue';
import Login from '@/components/Login.vue';
import Register from '@/components/Register.vue';

export default [
  {
    path: '/',
    component: GuestLayout,
    children: [
      {
        path: '',
        name: 'Login',
        component: Login,
      },
      {
        path: 'register',
        name: 'register',
        component: Register,
      }
    ]
  }
];
