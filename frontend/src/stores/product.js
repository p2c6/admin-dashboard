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
    const files = ref([]);

    const getAllProduct = async() => {
        isLoading.value = true;

        if (products.value) {
            return products.value;
        }

        try {
            const response = await http.get('/products')

            if (response.status == 200) {
                products.value = response.data;
                return products.value;
            }
        } catch (error) {
            console.log('Error getting all product', error);
        } finally {
            isLoading.value = false;
        }
    }

    const getProduct = async(id) => {
        try {
            const response = await http.get(`/products/${id}`)

            if (response.status == 200) {
                console.log('resppp', response.data)
                return response.data
            }
        } catch (error) {
            
        }
    }

    const createProduct = async(formData) => {
        try {
            isLoading.value = true;

            const payload = {
                name: formData.name,
                category: formData.category,
                description: formData.description,
                dateAndTime: formData.dateAndTime,
                product_image: files.value
            }

            const response = await http.post('/products', payload);

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

    const updateProduct = async(formData) => {
        try {
            isLoading.value = true;

            const payload = {
                name: formData.name,
                category: formData.category,
                description: formData.description,
                dateAndTime: formData.dateAndTime,
                product_image: files.value
            }

            const response = await http.put(`/products/${formData.id}`, payload);

            if (response.status === 200) {
                message.value =  response.data.message;
                products.value = null;
                router.push({name: 'products'});
            }
        } catch (error) {
            if (error.status === 422) {
                errors.value = error.response.data.errors;
                return;
            }
            
            console.error('Updating product error:', error);
        } finally {
            isLoading.value = false;
        }
    }

    const deleteProduct = async(id) => {
        try {
            isLoading.value = true;

            const response = await http.delete(`/products/${id}`);

            if (response.status === 200) {
                message.value =  response.data.message;
                products.value = null;
                router.push({name: 'products'});

                return true;
            }
        } catch (error) {
            if (error.status === 422) {
                errors.value = error.response.data.errors;
                return;
            }
            
            console.error('Deleting product error:', error);
        } finally {
            isLoading.value = false;
        }
    }

    return {
        message,
        products,
        files,
        errors,
        isLoading,
        createProduct,
        getAllProduct,
        updateProduct,
        getProduct,
        deleteProduct
    }
})