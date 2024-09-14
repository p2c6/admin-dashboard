<script setup>
import { ref } from 'vue';
import Content from "@/components/reusables/Content.vue";
import Card from "@/components/reusables/Card.vue";
import { onMounted,  } from "vue";
import {  useAuthStore } from "@/stores/auth";
import { useRouter } from "vue-router";
import { useProductStore } from "@/stores/product";
import DataTable from '@/components/DataTable.vue';

const authStore = useAuthStore();
const productStore = useProductStore();

const router = useRouter();

const headers = ref([
  { label: 'ID', key: 'id' },
  { label: 'Name', key: 'name' },
  { label: 'Category', key: 'category' },
  { label: 'Description', key: 'description' },
  { label: 'Date And Time', key: 'date_and_time' },
  { label: 'Actions', key: 'actions' } 
]);


const rows = ref([]);

onMounted(async() => {
    
    if (!authStore.user) {
        router.push({name: 'login'})
    }

    if (productStore.products) {
        rows.value = productStore.products;
    } else {
        rows.value = await productStore.getAllProduct();
    }
})

</script>

<template>
    <Content title="Listing of All Product" current="Products">
        <RouterLink :to="{name: 'products.create'}">
                <a class="btn btn-primary mb-2">Create</a>
        </RouterLink>
        <div v-if="productStore.message" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ productStore.message }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <Card>
            <div v-if="rows.length === 0" class="d-flex justify-content-center align-items-center">
                <div class="spinner-border spinner-border-sm mr-2 text-primary" role="status"></div>
              <span class="text-primary">Loading...</span>
            </div>
            <DataTable v-else :headers="headers" :rows="rows" />
        </Card>
    </Content>
</template>