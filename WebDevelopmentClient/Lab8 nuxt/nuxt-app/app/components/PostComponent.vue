<script setup lang="ts">
import type {Post} from "~/types/blog";
import type {DropdownMenuItem} from "@nuxt/ui/components/DropdownMenu.vue";
import {UDropdownMenu} from "#components";

const props = defineProps<{
  post: Post | null,
}>()

const handleDelete = (id: number) => {
  $fetch(`/api/admin/blog/posts/${id}`, { method: 'DELETE', })
    .then(res => {
      navigateTo('/blog/postsUI');
    })
}

const adminOptions: DropdownMenuItem[] = [
  {
    label: 'Edit',
    color: 'neutral',
    icon: 'i-lucide-square-pen',
    onClick: () => {
      if (props.post)
        navigateTo(`/admin/blog/posts/${props.post.slug}/edit`)
    }
  },
  {
    label: 'Delete',
    icon: 'i-lucide-trash',
    color: 'error',
    onClick: () => {
      if (props.post)
      handleDelete(props.post.id)
    }
  }
];

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
            <UDropdownMenu
              :items="adminOptions"
              class="m-2">
              <UButton variant="ghost" color="neutral" class="w-8 rounded-xl" icon="i-lucide-ellipsis-vertical" />
            </UDropdownMenu>
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
