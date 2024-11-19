<template>
  <div class="app">
    <AppHeader />
    <AddCan @add-can="addCan" />
    <CanFilter @filter-change="filterCans" />
    <CanList :cans="filteredCans" @delete-can="deleteCan" />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import AppHeader from './components/AppHeader.vue';
import AddCan from './components/AddCan.vue';
import CanFilter from './components/CanFilter.vue';
import CanList from './components/CanList.vue';

const cans = ref([]);
const filterText = ref('');

//Load initial cans
onMounted(async () => {
  try {
    const response = await fetch('/can-data.json');
    if (!response.ok) {
      throw new Error('Failed to load can data');
    }
    const data = await response.json();
    cans.value = data; // Populate cans with the loaded data
  } catch (error) {
    console.error('Error loading can data:', error);
  }
});

const addCan = (newCan) => {
  cans.value.push(newCan);
};

const deleteCan = (canId) => {
  // Send AJAX request to delete the can
  $.ajax({
    url: 'include/requests.php',
    type: 'POST',
    data: { deleteCanId: canId },
    success: function () {
      // Remove the can from the cans array in Vue
      cans.value = cans.value.filter(can => can.id !== canId);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error('Error:', textStatus, errorThrown);
    }
  });
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
