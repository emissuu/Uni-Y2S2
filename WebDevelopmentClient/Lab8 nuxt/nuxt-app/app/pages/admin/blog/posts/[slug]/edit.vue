<script setup lang="ts">
import type {Post} from "~/types/blog";

const route = useRoute();
const post = ref<Post | null>(null);
const getPost = () => {
  $fetch<{data: Post}>('/api/blog/posts/' + route.params.slug)
    .then((response) => {
      post.value = response.data;
      useSeoMeta({
        title: 'Editing blog post',
        description: `Page for editing post ${response.data.title}`,
      });
    })
}

getPost();
</script>

<template>
  <div class="w-[80%] ml-[10%]">
    <div class="mt-4 mb-6">
      <a href="/blog/postsUI" class="text-gray-500 text-sm"><< back to all posts</a>
    </div>
    <PostEditComponent
    :editedPost="post"/>
  </div>
</template>

<style scoped>

</style>
