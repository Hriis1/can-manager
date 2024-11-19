<template>
  <div class="app min-h-screen bg-gray-100 p-4">
    <AppHeader class="mb-4" />

    <div class="container mx-auto">
      <!-- Main content wrapper with a grid layout -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- AddCan Component -->
        <div class="md:col-span-1 bg-white p-4 rounded shadow">
          <AddCan @add-can="addCan" />
        </div>

        <!-- CanFilter Component -->
        <div class="md:col-span-2 flex items-center bg-white p-4 rounded shadow">
          <CanFilter @filter-change="filterCans" />
        </div>
      </div>

      <!-- CanList Component -->
      <div class="mt-6 bg-white p-4 rounded shadow">
        <CanList :cans="filteredCans" @delete-can="deleteCan" />
      </div>
    </div>
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
