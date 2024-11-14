<template>
  <div class="bg-white border border-gray-300 rounded-lg shadow-md overflow-hidden max-w-sm">
    <img
      class="w-full max-card-img-sz object-cover"
      :src="can.image"
      alt="Can Image"
    />
    <div class="p-4">
      <h5 class="text-lg font-semibold text-gray-800 mb-2">{{ can.name }}</h5>
      <p class="text-sm text-gray-600 mb-4">{{ can.description }}</p>
      <button
        @click="close"
        class="w-full bg-red-500 text-white py-2 rounded-md hover:bg-red-600 transition-colors"
      >
        Close
      </button>
    </div>
  </div>
</template>

<script setup>
defineProps({
  can: Object,
  close: Function
});
</script>

<style scoped>
.max-card-img-sz
{
  max-height: 500px;
}
</style>
