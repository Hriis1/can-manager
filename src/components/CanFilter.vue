<template>
  <input v-model="filterText" @input="filterChanged" placeholder="Filter Cans by Name"
    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" />
</template>

<script setup>
import { ref } from 'vue';
const filterText = ref('');

const emit = defineEmits(['filter-change']);
const filterChanged = () => {
  emit('filter-change', filterText.value);
};
</script>

<style scoped></style>