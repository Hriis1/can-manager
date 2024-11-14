<template>
  <div class="can-list">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Name
          </th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Description
          </th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Image
          </th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Actions
          </th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <tr v-for="can in props.cans" :key="can.name">
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ can.name }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ can.description }}</td>
          <td class="px-6 py-4 whitespace-nowrap">
            <img :src="can.image" alt="Can Image" class="w-16 h-auto" />
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
            <button
              @click="openModal(can)"
              class="text-blue-600 hover:text-blue-900 mr-4"
            >
              View
            </button>
            <button
              @click="deleteCan(can.name)"
              class="text-red-600 hover:text-red-900"
            >
              Delete
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Modal for displaying CanCard -->
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
      <div class="bg-white rounded-lg p-6 max-w-md w-full">
        <CanCard :can="selectedCan" />
        <button
          @click="closeModal"
          class="mt-4 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700"
        >
          Close
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import CanCard from './CanCard.vue';
import { defineProps, defineEmits } from 'vue';

const props = defineProps({ cans: Array });
const emit = defineEmits(['delete-can']);

const showModal = ref(false);
const selectedCan = ref(null);

const openModal = (can) => {
  selectedCan.value = can;
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
  selectedCan.value = null;
};

const deleteCan = (canName) => {
  emit('delete-can', canName);
};
</script>

<style scoped>
/* Custom styles for modal */
.fixed {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}

.bg-black {
  background-color: rgba(0, 0, 0, 0.5);
}

.flex {
  display: flex;
}

.items-center {
  align-items: center;
}

.justify-center {
  justify-content: center;
}
</style>
