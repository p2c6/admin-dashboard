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
  
  // Define methods for Edit and Delete
  const editRow = (row) => {
    alert(`Editing row: ${JSON.stringify(row)}`);
    // Add your logic for editing here
  };
  
  const deleteRow = (row) => {
    const confirmation = confirm(`Are you sure you want to delete ${row.name}?`);
    if (confirmation) {
      // Add your logic for deleting here
      alert(`Deleted row: ${row.name}`);
    }
  };
  </script>
  
  <style scoped>
  /* Custom styling if needed */
  </style>
  