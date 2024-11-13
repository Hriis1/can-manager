<template>
  <!-- Modal toggle button -->
  <button @click="showModal = true"
    class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
    type="button">
    Add Can
  </button>

  <!-- Main modal -->
  <div v-if="showModal" tabindex="-1" aria-hidden="true"
    class="fixed inset-0 z-50 flex justify-center items-center w-full h-full bg-black bg-opacity-50">
    <div class="relative p-4 w-full max-w-md max-h-full">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <!-- Modal header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
            Add Can
          </h3>
          <button @click="showModal = false" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto
            inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <!-- Modal body -->
        <div class="p-4 md:p-5">
          <form @submit.prevent="submitForm" class="space-y-4">
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Can Name</label>
              <input id="name" v-model="name" type="text" placeholder="Can Name" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white" />
            </div>
            <div>
              <label for="can_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Image File</label>
              <input id="can_image" type="file" @change="handleFileChange" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white" />
            </div>
            <div>
              <label for="description"
                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
              <textarea id="description" v-model="description" placeholder="Description"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white"
                rows="3"></textarea>
            </div>

            <button type="submit"
              class="w-full px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-blue-700 dark:hover:bg-blue-800 dark:focus:ring-blue-800">
              Add
            </button>
          </form>

        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import $ from 'jquery';
import { ref } from 'vue';

// Define the modal visibility state
const showModal = ref(false);

const file = ref(null);
const name = ref('');
const description = ref('');

const handleFileChange = (event) => {
  const selectedFile = event.target.files[0];
  if (selectedFile) {
    file.value = selectedFile;
  }
};

const emit = defineEmits(['add-can']);

const submitForm = () => {
  const formData = new FormData();
  formData.append('can_image', file.value);
  formData.append('name', name.value); // Include name
  formData.append('description', description.value); // Include description

  $.ajax({
    url: 'http://localhost/can-manager/include/requests.php',
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      const data = JSON.parse(response);
      if (data.url) {
        emit('add-can', { name: name.value, image: data.url, description: description.value });

        // Clear form data and close the modal
        name.value = '';
        file.value = null;
        description.value = '';
        showModal.value = false;
      } else {
        console.error('Error:', data.error);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error('Error uploading image:', textStatus, errorThrown);
    }
  });
};


</script>

<style scoped></style>
