<template>
    <input v-model="filterText" @input="filterChanged" placeholder="Filter Cans by Name" />
  </template>
  
  <script setup>
  import { ref } from 'vue';
  const filterText = ref('');
  
  const emit = defineEmits(['filter-change']);
  const filterChanged = () => {
    emit('filter-change', filterText.value);
  };
  </script>
  
  <style scoped>
  </style>
  