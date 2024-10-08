import { defineStore } from 'pinia';
import { reactive, ref } from 'vue';
import useAxios from '@/useAxios';
import { useRouter } from 'vue-router';

const { http } = useAxios();

export const useAuthStore = defineStore('auth', () => {
  const router = useRouter();
  const user = ref(null); 
  const errors = ref(null);
  const isLoading = ref(false)

  const login = async (credentials) => {    
    const method = credentials.email_username.includes('@') ? 'email' : 'username';

    let updatedCredentials = {
      email: credentials.email_username,
      password: credentials.password,
      remember: credentials.rememberMe,
      method: method
    };

    if (method === 'username') {
      updatedCredentials = {
        username: credentials.email_username,
        password: credentials.password,
        remember: credentials.rememberMe,
        method: method
      };
    }

    try {
      isLoading.value = true;
      const response = await http.post('/authentication/login', updatedCredentials);

      if (response.status === 200) {
        errors.value = null
        await getUser();
        router.push({name: 'home'})
      }

    } catch (error) {

      if (error.status === 422) {
        errors.value = error.response.data.errors;
        return;
      }
    
      console.error('Login error:', error);
    } finally {
      isLoading.value = false
    }
  };

  const getUser = async() => {
    try {
        isLoading.value = true;

        const { data } = await http.get('/user');
        user.value = data;
    } catch (error) {
        console.log('Error getting user', error)
        user.value = null;
    } finally {
      isLoading.value = false;
    }
  }

  const logout = async () => {
    try {
      const response = await http.post('/authentication/logout');

      if (response.status === 200) {
        errors.value = null
        user.value = null
        router.push({name: 'login'})
      }

    } catch (error) {
      console.error('Login error:', error);
    }
  };

  return {
    /*
      Variables
    */ 
    user,
    errors,
    isLoading,
    /*
      Functions
    */ 
    login,
    logout,
    getUser,
  };
});
