<script setup>
import Content from "@/components/Content.vue";
import Card from "@/components/Card.vue";
import { onMounted, reactive } from "vue";
import {  useAuthStore } from "@/stores/auth";
import { useRouter } from "vue-router";
import { ref } from 'vue';
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css'; 

const formData = reactive({
  name: '',
  category: '',
  description: '',
  dateAndTime: '',
})

const authStore = useAuthStore();
const router = useRouter();

onMounted(async() => {
    if (!authStore.user) {
        router.push({name: 'login'})
    }
})

</script>

<template>
    <Content title="Listing of All Post" current="Products">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Create Product</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form @submit.prevent="">
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter email" v-model="formData.name">
                  </div>
                  <div class="form-group">
                    <label for="category">Category</label>
                    <select class="form-control" id="category">
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
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
    </Content>
</template>

<style scope>
.editor-input {
  height: 200px;  /* Custom height */
  width: 100%;    
}
</style>