<script setup>
import Content from "@/components/Content.vue";
import Card from "@/components/Card.vue";
import { onMounted } from "vue";
import {  useAuthStore } from "@/stores/auth";
import { useRouter } from "vue-router";
import { QuillEditor } from 'vue-quill-editor';

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
            <div class="card card-primary">
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
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                  </div>
                 
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
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