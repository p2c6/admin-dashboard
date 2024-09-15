<script setup>
import { onMounted, ref, watch } from 'vue';
import $, { data } from 'jquery';
import 'datatables.net';
import { useRouter } from 'vue-router';
import { useProductStore } from '@/stores/product';

const router = useRouter();

const productStore = useProductStore()

const props = defineProps({
  headers: {
    type: Array,
    required: true,
  },
  rows: {
    type: Array,
    required: true,
  },
});

const dataTable = ref(null);

onMounted(async() => {
  $(dataTable.value).DataTable({
    paging: true,
    searching: true,
    ordering: true,
    info: true,
  });
});

const editRow = (row) => {
  router.push({name: 'products.update', params: {id: row.id}})
};
const emits = defineEmits(['delete-row']);

const handleDeleteRow = async (row) => {
  emits('delete-row', row)
};

</script>

<template>
    <div class="container mt-4">
      <table ref="dataTable" class="display table table-bordered table-striped table-responsive">
        <thead>
          <tr>
            <th v-for="(header, index) in headers" :key="index">
              {{ header.label }}
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(row, rowIndex) in rows" :key="rowIndex">
            <td v-for="(header, colIndex) in headers" :key="colIndex">
              <template v-if="header.key === 'actions'">
                <button @click="editRow(row)" class="btn btn-primary btn-sm mr-1">Edit</button>
                <button @click="handleDeleteRow(row)" class="btn btn-warning btn-sm">Delete</button>
              </template>
              <template v-else>
                <span v-html="row[header.key]"></span>
              </template>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>

  