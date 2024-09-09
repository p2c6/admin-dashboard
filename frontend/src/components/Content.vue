<script setup>
import { computed, defineProps } from 'vue';
import { RouterLink } from 'vue-router';

const props = defineProps({
    title: {
        type: String,
    },
    current: {
        type: String,
    }
})

const finalLink = props.current ? props.current.toLowerCase() : null
</script>

<template>
      <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ props.title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a :href="`/`">Home</a></li>
                    <li class="breadcrumb-item" v-if="props.current">
                        <RouterLink :to="{name: finalLink}">
                            <a>{{ props.current }}</a>
                        </RouterLink>
                    </li>
                    <!-- <li class="breadcrumb-item active">Fixed Layout</li> -->
                    </ol>
                </div>
                </div>
            </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">

            <div class="container-fluid">
                <div class="row">
                <div class="col-12">
                    <!-- Default box -->
                    <slot></slot>
                    <!-- /.card -->
                </div>
                </div>
            </div>
            </section>
            <!-- /.content -->
        </div>
</template>