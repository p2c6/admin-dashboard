<script setup>
import { useAuthStore } from "@/stores/auth";
import { reactive } from 'vue';

const authStore = useAuthStore();

const formData = reactive({
  email_username: '',
  password: '',
  rememberMe: false
});


</script>

<template>
    <div class="login-box">
  <div class="login-logo">
    <a><b>Admin</b>LTE</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form @submit.prevent="authStore.login(formData)" method="post">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Email or Username" v-model="formData.email_username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <p class="text-danger text-xs mt-1" v-if="authStore.errors && authStore.errors.username">{{ authStore.errors.username[0] }}</p>
        <p class="text-danger text-xs mt-1" v-if="authStore.errors && authStore.errors.email">{{ authStore.errors.email[0] }}</p>

        <div class="input-group mt-3">
          <input type="password" class="form-control" placeholder="Password" v-model="formData.password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <p class="text-danger text-xs mt-1" v-if="authStore.errors && authStore.errors.password">{{ authStore.errors.password[0] }}</p>

        <div class="row mt-4">
          <div class="col-7">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" v-model="formData.rememberMe">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <div class="col-5">
            <button v-if="authStore.isLoading" class="btn btn-primary disabled d-flex">
              <div class="spinner-border spinner-border-sm mr-2" role="status"></div>
              Loading...
            </button>

            <button v-else type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
        </div>
      </form>


      
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
</template>