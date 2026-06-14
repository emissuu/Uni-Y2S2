<script setup lang="ts">
import type {Post} from "~/types/blogPost";

const route = useRoute()
const post = ref<Post | null>(null)
const getPost = () => {
  $fetch<Post>('/api/blog-posts/' + route.params.slug)
    .then((response) => {
      post.value = response;
    })
}

getPost();
</script>

<template>
  <div class="w-[80%] ml-[10%]">
    <div class="mt-4 mb-6">
      <a href="/blog/postsUI" class="text-gray-500 text-sm"><< back to all posts</a>
    </div>
    <div class="border-gray-300 border-2 rounded-xl overflow-hidden shadow-sm mb-4">
      <PostComponent
        :post="post"
      />
    </div>
  </div>
</template>

<style scoped>

</style>
