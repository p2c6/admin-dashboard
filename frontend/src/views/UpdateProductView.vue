<script setup>
import Content from "@/components/reusables/Content.vue";
import UpdateProductForm from "@/components/forms/UpdateProductForm.vue";
import { onMounted } from "vue";
import {  useAuthStore } from "@/stores/auth";
import { useRouter } from "vue-router";

const authStore = useAuthStore();
const router = useRouter();

onMounted(async() => {
    if (!authStore.user) {
        router.push({name: 'login'})
    }
})

</script>

<template>
    <Content title="Update Product" current="Products">
      <UpdateProductForm />
    </Content>
</template>