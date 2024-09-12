<script setup>
import { defineProps } from 'vue';

defineProps({
    header: {
        type: String
    },
    footer: {
        type: String
    }
})
</script>

<template>
    <div class="card">
        <div class="card-header" v-if="header">
            <h3 class="card-title">{{ header }}</h3>
        </div>
        <div class="card-body">
            <slot></slot>
        </div>
        <!-- /.card-body -->
        <div class="card-footer" v-if="footer">
            {{  footer }}
        </div>
        <!-- /.card-footer-->
    </div>
</template>