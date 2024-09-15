<script setup>
import { onMounted, onUnmounted, reactive, ref } from 'vue';
import CustomDropzone from "@/components/CustomDropzone.vue"
import SummernoteEditor from "@/components/SummernoteEditor.vue"
import { useProductStore } from '@/stores/product';
import { useRoute, useRouter } from 'vue-router';

const productStore = useProductStore();
const route = useRoute()

const formData = reactive({
  id: '',
  name: '',
  category: '',
  description: '',
  dateAndTime: '',
})

const id = route.params.id;

const product = ref({});

onMounted(async () => {
  productStore.errors = null;

  product.value = await productStore.getProduct(id); 
  productStore.files = product.value.images;
  
  formData.name = product.value.name;
  formData.category = product.value.category;
  formData.description = product.value.description;
  formData.dateAndTime = product.value.date_and_time;
  formData.id = id;

})

onUnmounted(() => {
  productStore.files = null;
})

</script>

<template>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Create Product</h3>
                
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form @submit.prevent="productStore.updateProduct(formData)">
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter email" v-model="formData.name">
                  </div>
                  <p class="text-danger text-xs mt-1" v-if="productStore.errors && productStore.errors.name">{{ productStore.errors.name[0] }}</p>

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

                  <p class="text-danger text-xs mt-1" v-if="productStore.errors && productStore.errors.category">{{ productStore.errors.category[0] }}</p>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Description</label>
                    <SummernoteEditor v-model="formData.description" />
                  </div>

                  <p class="text-danger text-xs mt-1" v-if="productStore.errors && productStore.errors.description">{{ productStore.errors.description[0] }}</p>

                  <div class="form-group">
                    <label for="dateAndTime">Date and Time</label>
                    <input type="datetime-local" id="dateAndTime" name="dateAndTime" class="form-control" v-model="formData.dateAndTime">
                  </div>
                  <div class="form-group">
                    <label for="">Image</label>
                    <CustomDropzone  />

                  </div>

                  <p class="text-danger text-xs mt-1" v-if="productStore.errors && productStore.errors.product_image">{{ productStore.errors.product_image[0] }}</p>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
</template>
