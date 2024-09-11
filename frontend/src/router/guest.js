// guest.js
import GuestLayout from '@/components/layouts/GuestLayout.vue';
import Login from '@/components/Login.vue';
import Register from '@/components/Register.vue';

export default [
  {
    path: '/',
    redirect: { name: 'login' }, 
  },
  {
    path: '/guest',
    name: 'guest',
    component: GuestLayout,
    children: [
      {
        path: '',
        name: 'login',
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
