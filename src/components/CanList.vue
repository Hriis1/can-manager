<template>
    <div class="can-list">
      <CanCard v-for="can in props.cans" :key="can.name" :can="can" @delete-can="deleteCan" />
    </div>
  </template>
  
  <script setup>
  import { defineProps, defineEmits } from 'vue';
  import CanCard from './CanCard.vue';
  
  const props = defineProps({ cans: Array });
  
  const emit = defineEmits(['delete-can']);
  
  const deleteCan = (canName) => {
    emit('delete-can', canName);
  };
  </script>
  
  <style scoped>
  /* Add your styling here */
  </style>
  