<template>
    <div class="container mt-4">
      <table ref="dataTable" class="display table table-bordered table-striped">
        <thead>
          <tr>
            <th v-for="(header, index) in headers" :key="index">
              {{ header.label }} <!-- Display the header label -->
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(row, rowIndex) in rows" :key="rowIndex">
            <td v-for="(header, colIndex) in headers" :key="colIndex">
              <template v-if="header.key === 'actions'">
                <button @click="editRow(row)" class="btn btn-primary btn-sm">Edit</button>
              </template>
              <template v-else>
                <span v-html="row[header.key]"></span> <!-- Render HTML content -->
              </template>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script setup>
  import { onMounted, ref } from 'vue';
  import $ from 'jquery';
  import 'datatables.net';
  import { useRouter } from 'vue-router';
  
  const router = useRouter();
  
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
  
  onMounted(() => {
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
  
  const deleteRow = (row) => {
    const confirmation = confirm(`Are you sure you want to delete ${row.name}?`);
    if (confirmation) {
      alert(`Deleted row: ${row.name}`);
    }
  };
  </script>

  