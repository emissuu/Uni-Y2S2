<script setup lang="ts">
import type {Category} from "~/types/blog";

const route = useRoute();
const category = ref<Category | null>(null);
const getCategory = () => {
  $fetch<{data: Category}>('/api/admin/blog/categories/' + route.params.id)
    .then((response) => {
      category.value = response.data;
    })
}

getCategory();
</script>

<template>
  <div class="w-[50%] ml-[25%]">
    <div class="mt-4 mb-6 ">
      <a href="/blog/categories" class="text-gray-500 text-sm"><< back to all categories</a>
    </div>
    <div class="border-gray-300 border-2 rounded-xl overflow-hidden shadow-sm">
      <CategoryEditComponent
        :editedCategory="category"/>
    </div>
  </div>
</template>

<style scoped>

</style>
