
<script setup>
import { onMounted, reactive, ref, watch } from 'vue';
import Dropzone from 'dropzone';
import 'dropzone/dist/dropzone.css'; 
import useAxios from '@/useAxios';
import { useProductStore } from '@/stores/product';
import { useRoute } from 'vue-router';

const route = useRoute();

const id = route.params.id;

const dropzone = ref(null);
const { http } = useAxios();

const productStore = useProductStore();

onMounted( async() => {
  const myDropzone = new Dropzone(dropzone.value, {
    url: '/uploader/upload',
    maxFilesize: 2,
    acceptedFiles: ".jpg,.png,.gif",
    addRemoveLinks: true,
    dictRemoveFile: "Remove file",
    dictDefaultMessage: "Drop files here to upload",

    init: async function () {

      if(id) {
        
        const { images } =  await productStore.getProduct(id);

        images.forEach(function (file) {

          let mockFile = {
              name: file.split('/').pop(),
              size: 12345,
              url: file
          };

          myDropzone.files.push(mockFile);
          myDropzone.emit("addedfile", mockFile);
          myDropzone.emit("thumbnail", mockFile, mockFile.url);
          myDropzone.emit("complete", mockFile); 
        });
    }

      this.on("sending", function (file, xhr, formData) {
        // Add additional data to formData if needed
        formData.append("extraData", "value");
      });

      this.on("error", function (file, response) {
        console.error("Upload error:", response);
      });

      this.on("success", function (file, response) {
        productStore.files.push(response.file_path)
      });

      this.on("removedfile", function (file) {
          try {
            
            if(file.upload) {
              const filePath = file.upload.filename;

              http.post('/uploader/revert', { file_path: filePath })
                .then(response => {
                  if (response.data.message) {
                    productStore.files = productStore.files.filter(item => item !== filePath);
                  }
                })
                .catch(error => {
                  console.error('Error removing file:', error.response ? error.response.data : error.message);
                });
            } else {
              productStore.files = productStore.files.filter(item => item !== file.url);
            }


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

.dropzone .dz-preview .dz-image {
    width: 100px;
    height: 100px;
    position: relative;
    display: block;
    z-index: 10;
}

.dropzone .dz-preview .dz-image img{
    width: 100px;
    height: 100px;
    object-fit: contain;
}
</style>
