<script setup>
import { ref, watch } from 'vue';
import Content from "@/components/reusables/Content.vue";
import Card from "@/components/reusables/Card.vue";
import { onMounted,  } from "vue";
import {  useAuthStore } from "@/stores/auth";
import { useRoute, useRouter } from "vue-router";
import { useProductStore } from "@/stores/product";
import DataTable from '@/components/DataTable.vue';

const authStore = useAuthStore();
const productStore = useProductStore();

const router = useRouter();

const headers = ref([
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

const deleteRow = async(rowToDelete) => {
  const confirmation = confirm(`Are you sure you want to delete ${rowToDelete.name}?`);
  if (confirmation) {
    await productStore.deleteProduct(rowToDelete.id);
    rows.value = await productStore.getAllProduct();
  }
}

watch(productStore.message, (newValue, oldValue) => {
    console.log('newValue: ' + newValue + " oldvalue: " + oldValue)
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
            <div v-if="productStore.isLoading && rows.length === 0" class="d-flex justify-content-center align-items-center">
                <div class="spinner-border spinner-border-sm mr-2 text-primary" role="status"></div>
              <span class="text-primary">Loading...</span>
            </div>
            <DataTable v-else-if="!productStore.isLoading && rows.length > 0" :headers="headers" :rows="rows" @delete-row="deleteRow" />
            <div v-else>
                <p class="d-flex justify-content-center align-items-center mt-5">No data found.</p>
            </div>
        </Card>
    </Content>
</template>