<script setup lang="ts">
useSeoMeta({
  title: 'All categories',
  description: 'Page for viewing and managing all blog categories',
});
</script>

<template>
  <div class="w-[80%] my-8 ml-[10%] border-gray-300 border-2 rounded-xl overflow-hidden shadow-sm">
    <CategoriesTableUI />
  </div>
</template>

<style scoped>

</style>
