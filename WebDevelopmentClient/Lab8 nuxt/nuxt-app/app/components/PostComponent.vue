<script setup lang="ts">
import type {Post} from "~/types/blog";

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
      <header class="bg-gray-100 px-4 border-b-1 border-gray-300 py-2">
        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <div class="rounded-full overflow-hidden h-10 w-10 border-gray-300 border-1">
              <img :src="post.author_image_url" />
            </div>
            <p class="ml-2">{{post.author_name}}</p>
          </div>
          <div class="flex items-center gap-4">
            <p v-if="post.date_updated">Last update: {{(new Date(post.date_updated)).toLocaleDateString()}}</p>
            <p v-if="post.is_published">Published at: {{ (new Date(post.date_published)).toLocaleDateString() }}</p>
            <p v-else>Not published yet</p>
          </div>
        </div>
      </header>
      <main class="p-6 text-justify">
        <div class="relative">
          <div class="absolute right-4 -mr-4">
            <UButton variant="ghost" color="neutral" class="w-8 rounded-xl" icon="i-lucide-ellipsis-vertical" />
          </div>
          <h2 class="font-bold text-3xl mb-1 w-[95%] text-wrap">
            {{post.title}}
          </h2>
          <h3 class="font-semibold text-lg text-gray-400 mb-4 w-[90%] text-wrap">
            {{ post.category_title }}
          </h3>
          <p>
            {{post.content}}
          </p>
        </div>
      </main>

    </div>

  </div>
</template>

<style scoped>

</style>
