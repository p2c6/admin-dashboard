import { defineStore } from "pinia";
import { ref } from "vue";
import apiClient from "../apiClient";

export const useAuthStore = defineStore('auth', () => {
    const user = ref(null);

    const login = async (credentials) => {
        await apiClient.get('/sanctum/csrf-cookie');

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

        console.log('formdata' , updatedCredentials);

                
        const response = await apiClient.post('/api/login', updatedCredentials);

        console.log('resp', response)
    }

    return {
        login
    }
})