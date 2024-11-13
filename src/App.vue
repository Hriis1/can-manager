<template>
  <div class="app">
    <header><h1>Interactive Can Manager</h1></header>
    <AddCan @add-can="addCan" />
    <CanFilter @filter-change="filterCans" />
    <CanList :cans="filteredCans" @delete-can="deleteCan" />
  </div>
</template>

<script setup>
import $ from 'jquery';
import { ref, computed } from 'vue';
import AddCan from './components/AddCan.vue';
import CanFilter from './components/CanFilter.vue';
import CanList from './components/CanList.vue';

const cans = ref([]);
const filterText = ref('');

const addCan = (newCan) => {
  cans.value.push(newCan);
};

const deleteCan = (canName) => {
  cans.value = cans.value.filter(can => can.name !== canName);
};

const filterCans = (text) => {
  filterText.value = text;
};

const filteredCans = computed(() => {
  if (!filterText.value) return cans.value;
  return cans.value.filter(can => can.name.includes(filterText.value));
});
</script>

<style scoped>

</style>
