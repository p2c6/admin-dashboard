// auth.js
import AuthLayout from '@/components/layouts/AuthLayout.vue';
import HomeView from '@/views/HomeView.vue';
import VideosView from '@/views/VideosView.vue';
import ProductsView from '@/views/ProductsView.vue';
import CreateProductView from '@/views/CreateProductView.vue';
import UpdateProductView from '@/views/UpdateProductView.vue';

export default [
  {
    path: '/admin',
    component: AuthLayout,
    children: [
      {
        path: '',
        name: 'home',
        component: HomeView,
      },
      {
        path: 'products',
        name: 'products',
        component: ProductsView,
      },
      {
        path: 'products/create',
        name: 'products.create',
        component: CreateProductView,
      },
      {
        path: 'products/update/:id',
        name: 'products.update',
        component: UpdateProductView,
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
