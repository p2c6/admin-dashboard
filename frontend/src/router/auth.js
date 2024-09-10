import AuthLayout from '@/components/layouts/AuthLayout.vue';
import HomeView from '@/views/HomeView.vue';
import PostView from '@/views/PostView.vue';
import VideosView from '@/views/VideosView.vue';

export default  [
  {
    path: '/',
    component: AuthLayout,
    children: [
      {
        path: '',
        name: 'home',
        component: HomeView,
      },
      {
        path: 'posts',
        name: 'posts',
        component: PostView,
      },
      {
        path: 'videos',
        name: 'videos',
        component: VideosView,
      },
    ],
    meta: { requiresAuth: true }
  }
];
