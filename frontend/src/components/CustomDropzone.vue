
<script setup>
import { onMounted, ref, watch } from 'vue';
import Dropzone from 'dropzone';
import 'dropzone/dist/dropzone.css'; // Import the Dropzone CSS
import useAxios from '@/useAxios';
import { useProductStore } from '@/stores/product';


const dropzone = ref(null);
const { http } = useAxios(); // Use your Axios instance

const productStore = useProductStore();

onMounted(() => {
  console.log('productStore', productStore.files)
  const myDropzone = new Dropzone(dropzone.value, {
    url: '/uploader/upload', // Use relative URL
    maxFilesize: 2, // 2MB max file size
    acceptedFiles: ".jpg,.png,.gif",
    addRemoveLinks: true,
    dictRemoveFile: "Remove file",
    dictDefaultMessage: "Drop files here to upload",

    init: function () {
      this.on("sending", function (file, xhr, formData) {
        // Add additional data to formData if needed
        formData.append("extraData", "value");
      });

      this.on("error", function (file, response) {
        console.error("Upload error:", response);
      });

      this.on("success", function (file, response) {
        console.log("Upload successful:", response);
        productStore.files.push(response.file_path)
      });

      this.on("removedfile", function (file) {
          try {
            const filePath = file.upload.filename;

            http.post('/uploader/revert', { file_path: filePath })
              .then(response => {
                console.log('response', response)
                if (response.data.message) {
                  productStore.files = productStore.files.filter(item => item !== filePath);
                }
              })
              .catch(error => {
                console.error('Error removing file:', error.response ? error.response.data : error.message);
              });
          } catch (e) {
            console.error('Error parsing response:', e);
          }
      });


      this.uploadFiles = function (files) {
        files.forEach(file => {
          const formData = new FormData();
          formData.append("file", file);

          http.post('/uploader/upload', formData, {
            headers: {
              'Content-Type': 'multipart/form-data',
            },
          })
          .then(response => {
            file.status = Dropzone.SUCCESS;
            file.upload.filename = response.data.file_path; 
            this.emit("success", file, response.data);
          })
          .catch(error => {
            file.status = Dropzone.ERROR;
            this.emit("error", file, error.response.data);
          })
          .finally(() => {
            this.emit("complete", file);
          });
        });
      };
    },
  });
});
</script>

<template>
  <div>
    <form ref="dropzone" class="dropzone" id="my-dropzone"></form>
  </div>
</template>

<style>
/* Optional: Customize the Dropzone styles */
.dropzone {
  border: 2px dashed #007bff;
  padding: 20px;
  background-color: #f8f9fa;
}
</style>
