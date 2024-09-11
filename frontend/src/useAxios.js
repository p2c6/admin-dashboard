// src/composables/useAxios.js
import axios from 'axios';
import { useRouter } from 'vue-router';

const router = useRouter();

const http = axios.create({
  baseURL: 'http://localhost:8000',
  headers: {
    'X-Requested-With': 'XMLHttpRequest',
  },
  withCredentials: true
});

const useAxios = () => {
  // Include CSRFF Token on headers if not get
  http.interceptors.request.use(async (config) => {
    if (config.method === 'post' || config.method === 'put' || config.method === 'patch' || config.method === 'delete') {
      if (!config.headers['X-XSRF-TOKEN']) {
        await http.get('/sanctum/csrf-cookie');
        
        const token = document.cookie
          .split('; ')
          .find(row => row.startsWith('XSRF-TOKEN='))
          ?.split('=')[1];
        
        if (token) {
          config.headers['X-XSRF-TOKEN'] = decodeURIComponent(token);
        }
      }
    }
    return config;
  });

  // Check session expiration and redirect to login if session expires
  http.interceptors.response.use(
    response => response,
    error => {
      if (error.response && error.response.status === 401) {
       
        router.push({name: 'login'}); // Redirect to login 
      }
      return Promise.reject(error);
    }
  );

  return { http };
};

export default useAxios;
