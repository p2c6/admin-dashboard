<script setup>
import Sidebar from "@/components/Sidebar.vue";
import { RouterView } from "vue-router";
import Footer from "@/components/Footer.vue";
</script>

<template>
    <Sidebar />
    <main>
        <RouterView />
    </main>
    <Footer />
</template>
  

  