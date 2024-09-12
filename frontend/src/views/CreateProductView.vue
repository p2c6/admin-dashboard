<script setup>
import Content from "@/components/reusables/Content.vue";
import CreateProductForm from "@/components/forms/CreateProductForm.vue";
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
    <Content title="Listing of All Post" current="Products">
      <CreateProductForm />
    </Content>
</template>