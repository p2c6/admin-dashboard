import { defineStore } from "pinia";
import { ref } from "vue";
import useAxios from '@/useAxios';
import { useRouter } from "vue-router";

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
            }
        }
                
        const response = await http.post('/api/login', updatedCredentials);

        if (response.status === 200) {
            const userData = await getUser();
            user.value = userData

            router.push({name: 'guest'})
        }
    }

    const getUser = async() => {
        try {
            const { data } = await http.get('/api/user')

            return data;            
        } catch (error) {
            console.error('Failed getting user:', error)
        }
    }

    return {
        user,
        login,
        getUser
    }
})