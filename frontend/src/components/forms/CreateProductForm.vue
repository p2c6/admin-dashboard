<script setup>
import { reactive } from 'vue';
import CustomDropzone from "@/components/CustomDropzone.vue"
import { useProductStore } from '@/stores/product';
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css'; 

const productStore = useProductStore();

const formData = reactive({
  name: '',
  category: '',
  description: '',
  dateAndTime: '',
})

</script>

<template>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Create Product</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form @submit.prevent="productStore.create(formData)">
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter email" v-model="formData.name">
                  </div>
                  <div class="form-group">
                    <label for="category">Category</label>
                    <select class="form-control" id="category" v-model="formData.category">
                        <option value="">Select Category</option>
                        <option value="Gadgets">Gadgets</option>
                        <option value="Appliances">Appliances</option>
                        <option value="Grocery">Grocery</option>
                        <option value="Clothes">Clothes</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Description</label>
                      <QuillEditor
                        v-model="formData.description"
                        theme="snow"
                        placeholder="Write something awesome..."
                        toolbar="full"
                        class="editor-input"
                      />
                  </div>
                  <div class="form-group">
                    <label for="dateAndTime">Date and Time</label>
                    <input type="datetime-local" id="dateAndTime" name="dateAndTime" class="form-control" v-model="formData.dateAndTime">
                  </div>
                  <div class="from-group">
                    <label for="">File</label>
                    <CustomDropzone />
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
</template>

<style scope>
.editor-input {
  height: 200px;  /* Custom height */
  width: 100%;    
}
</style>