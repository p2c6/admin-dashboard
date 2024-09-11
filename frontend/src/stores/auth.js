import { defineStore } from 'pinia';
import { reactive, ref } from 'vue';
import useAxios from '@/useAxios';
import { useRouter } from 'vue-router';

const { http } = useAxios();

export const useAuthStore = defineStore('auth', () => {
  const router = useRouter();
  const user = ref(null); 

  const login = async (credentials) => {
    const method = credentials.email_username.includes('@') ? 'email' : 'username';

    let updatedCredentials = {
      email: credentials.email_username,
      password: credentials.password,
      method: method
    };

    if (method === 'username') {
      updatedCredentials = {
        username: credentials.email_username,
        password: credentials.password,
        method: method
      };
    }

    try {
      const response = await http.post('/api/login', updatedCredentials);

      if (response.status === 200) {
        await getUser();
        router.push({name: 'home'})
      }
    } catch (error) {
      console.error('Login error:', error);
    }
  };

  const getUser = async() => {
    try {
        const { data } = await http.get('/api/user');
        user.value = data;
    } catch (error) {
        console.log('Error getting user', error)
        user.value = null;
    }
  }

  return {
    user,
    login,
    getUser
  };
});
