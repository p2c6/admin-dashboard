import { defineStore } from "pinia";
import { ref } from "vue";
import useAxios from "@/useAxios";
import {  useRouter } from "vue-router";

const { http } = useAxios();

export const useProductStore = defineStore('product', () => {
    const router = useRouter();
    const errors = ref(null);
    const isLoading = ref(false);
    const message = ref(null);
    const products = ref(null); 

    const getAllProduct = async() => {

        if (products.value) {
            return products.value;
        }

        try {
            const response = await http.get('/products')

            console.log('response', response)

            if (response.status == 200) {
                products.value = response.data;
                return products.value;
            }
        } catch (error) {
            
        }
    }

    const create = async(formData) => {
        try {
            isLoading.value = true;

            const response = await http.post('/products', formData);

            if (response.status === 201) {
                message.value =  response.data.message;
                products.value = null;
                router.push({name: 'products'});
            }
        } catch (error) {
            if (error.status === 422) {
                errors.value = error.response.data.errors;
                return;
            }
            
            console.error('Create product error:', error);
        } finally {
            isLoading.value = false;
        }
    }

    return {
        message,
        products,
        create,
        getAllProduct
    }
})