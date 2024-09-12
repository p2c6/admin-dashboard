<script setup>
import Content from "@/components/Content.vue";
import Card from "@/components/Card.vue";
import { onMounted } from "vue";
import {  useAuthStore } from "@/stores/auth";
import { useRouter } from "vue-router";
import { ref } from 'vue';
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css'; // Import CSS for Quill theme

const content = ref(''); // Binding content to the editor

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
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Category</label>
                    <select class="form-control">
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
                        v-model="content"
                        theme="snow"
                        placeholder="Write something awesome..."
                        toolbar="full"
                        class="editor-input"
                      />
                  </div>
                  <div class="form-group">
                    <label for="dateAndTime">Date and Time</label>
                    <input type="datetime-local" id="dateAndTime" name="dateAndTime" class="form-control">
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