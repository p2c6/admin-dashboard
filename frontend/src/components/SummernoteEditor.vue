<!-- SummernoteEditor.vue -->
<template>
    <div>
      <div ref="editor" class="summernote"></div>
    </div>
  </template>
  
  <script setup>
  import { onMounted, ref, defineEmits } from 'vue';
  import $ from 'jquery';
  import 'bootstrap/dist/css/bootstrap.min.css';
  import 'summernote/dist/summernote-bs5.css';
  import 'summernote/dist/summernote-bs5';
  
  // Define emit
  const emit = defineEmits(['update:modelValue']);
  
  const editor = ref(null);
  
  onMounted(() => {
    $(editor.value).summernote({
      height: 200,
      callbacks: {
        onChange: function(contents) {
          emit('update:modelValue', contents);
        }
      }
    });
  });
  </script>
  
  <style>
  .summernote {
    width: 100%;
  }
  </style>
  