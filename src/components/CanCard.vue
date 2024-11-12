<template>
    <div class="can-card">
      <h2>{{ can.name }}</h2>
      <img :src="can.image" alt="Can Image" />
      <p>{{ can.description }}</p>
      <button @click="deleteCan">Delete</button>
    </div>
  </template>
  
  <script setup>
  import { defineProps, defineEmits } from 'vue';
  
  const props = defineProps({ can: Object });
  const emit = defineEmits(['delete-can']);
  const deleteCan = () => {
    emit('delete-can', props.can.name);
  };
  </script>
  
  <style scoped>
  </style>
  