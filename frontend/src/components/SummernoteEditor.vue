<!-- SummernoteEditor.vue -->
<script setup>
import { onMounted, ref, watch, defineEmits, defineProps } from 'vue';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import $ from 'jquery';
import 'summernote/dist/summernote-bs5.css';
import 'summernote/dist/summernote-bs5';
import 'bootstrap/dist/css/bootstrap.min.css';

// Define props and emits
const props = defineProps(['modelValue']);
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

  // Update the editor content when modelValue changes
  $(editor.value).summernote('code', props.modelValue);
});

watch(() => props.modelValue, (newValue) => {
  if ($(editor.value).summernote('isEmpty') || newValue !== $(editor.value).summernote('code')) {
    $(editor.value).summernote('code', newValue);
  }
});
</script>

<template>
  <div>
    <div ref="editor" class="summernote"></div>
  </div>
</template>

<style>
.summernote {
  width: 100%;
}
</style>
