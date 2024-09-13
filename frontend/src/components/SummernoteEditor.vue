<!-- SummernoteEditor.vue -->
<template>
    <div>
      <div ref="editor" class="summernote"></div>
    </div>
  </template>
  
  <script setup>
  import { onMounted, ref, defineEmits } from 'vue';
  import 'bootstrap/dist/js/bootstrap.bundle.min.js'; // Ensure the tooltip and popper are included
  import $ from 'jquery';
  import 'summernote/dist/summernote-bs5.css';
  import 'summernote/dist/summernote-bs5';
  import 'bootstrap/dist/css/bootstrap.min.css';

  
  // Define emit
  const emit = defineEmits(['update:modelValue']);
  
  const editor = ref(null);
  
  onMounted(() => {
    $(editor.value).summernote({
      height: 200,
      tooltip: false,
      toolbar: [
        ['style', ['style', 'bold', 'italic', 'underline', 'clear', 'strikethrough']],

        ['font', ['fontname', 'fontsize', 'color']],

        ['para', ['ul', 'ol', 'paragraph', 'height']],

        ['misc', ['fullscreen']]
      ],
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
  