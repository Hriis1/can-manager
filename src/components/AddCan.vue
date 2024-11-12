<template>
    <form @submit.prevent="submitForm">
      <input v-model="name" placeholder="Can Name" required />
      <input v-model="image" placeholder="Image URL" required />
      <textarea v-model="description" placeholder="Description"></textarea>
      <button type="submit">Add Can</button>
    </form>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  const name = ref('');
  const image = ref('');
  const description = ref('');
  
  const emit = defineEmits(['add-can']);
  const submitForm = () => {
    emit('add-can', { name: name.value, image: image.value, description: description.value });
    name.value = '';
    image.value = '';
    description.value = '';
  };
  </script>
  
  <style scoped>
  </style>
  