<script setup lang="ts">
import type {Post} from "~/types/blogPost";

defineProps<{
  post: Post | null,
}>()
</script>

<template>
  <div>
    <div v-if="!post" class="flex justify-center w-full p-4">
      <p class="mb-120">Post is loading...</p>
    </div>
    <div v-else>
      <header class="bg-gray-100 px-4 border-b-1 border-gray-300 p-1">
        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <div class="rounded-full overflow-hidden h-10 w-10 border-gray-300 border-1">
              <img :src="post.user.profile_photo_url" />
            </div>
            <p class="ml-2">{{post.user.name}}</p>
          </div>
          <div class="flex items-center gap-4">
            <p v-if="post.updated_at">Last update: {{(new Date(post.updated_at)).toLocaleDateString()}}</p>
            <p v-if="post.is_published">Published at: {{(new Date(post.published_at)).toLocaleDateString()}}</p>
            <p v-else>Not published yet</p>
          </div>
        </div>
      </header>
      <main class="p-6 text-justify">
        <div class="relative">
          <div class="absolute right-4 -mr-4">
            <UButton variant="ghost" color="neutral" class="w-8">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-vertical-icon lucide-ellipsis-vertical -ml-[7px] -mr-2"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
            </UButton>
          </div>
          <h2 class="font-bold text-3xl mb-1 w-[95%] text-wrap">
            {{post.title}}
          </h2>
          <h3 class="font-semibold text-lg text-gray-500 mb-4 w-[90%] text-wrap">
            {{post.category.title}}
          </h3>
          <p>
            {{post.content_html}}
          </p>
        </div>
      </main>

    </div>

  </div>
</template>

<style scoped>

</style>
