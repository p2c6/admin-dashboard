<script setup>
import Sidebar from "@/components/Sidebar.vue";
import Loader from "@/components/Loader.vue";
import { RouterView } from "vue-router";
import Footer from "@/components/Footer.vue";
import { onMounted, ref } from "vue";
import { useAuthStore } from "@/stores/auth";

const authStore = useAuthStore();
const isLoading = ref(true)

onMounted(async () => {
    await authStore.getUser();
    isLoading.value = false;
});
</script>

<template>
    <Loader v-if="isLoading" />
    <div v-else>
        <Sidebar />
        <main>
            <RouterView />
        </main>
        <Footer />
    </div>
</template>
