<script setup lang="ts">
import type {Category, Post} from "~/types/blog";
import type {SelectMenuItem} from "@nuxt/ui/components/SelectMenu.vue";
import { z } from "zod";

const props = defineProps<{
  editedPost: Post | null
}>();

const formErrors = ref<Record<string,string>>({});

const post = ref({
  title:  "",
  content_raw:  "",
  category_id:  0,
  category_title:  "",
  is_published: false,
});

const selectMenuCategories = ref<SelectMenuItem[]>();

const getCategories = () => {
  $fetch<{ data: Category[] }>('/api/admin/blog/categories', { query: { per_page: 50}})
    .then((res) => {
      if (!post.value.category_id && res.data && res.data[0]) {
        post.value.category_id = res.data[0].id;
        post.value.category_title = res.data[0].title;
      }
      selectMenuCategories.value = res.data.map((c) => {
        return {
          label: c.title,
          onSelect: () => {post.value.category_id = c.id}
        }
      })
    })
}

const postSchema = z.object({
  title: z.string()
    .min(5, 'Title must be at least 5 characters long')
    .max(200, 'Title cannot be longer than 200 characters'),
  category_id: z.number('Category is required' ),
  content_raw: z.string()
    .min(5, 'The article must be at least 5 characters long')
    .max(10000, 'Article cannot be longer than 10000 characters')
})

const toast = useToast()

const handleSubmit = () => {
  formErrors.value = {};
  const resultPost = {
    title: post.value.title,
    category_id: post.value.category_id,
    content_raw: post.value.content_raw,
    is_published: post.value.is_published,
  };
  const validationResult = postSchema.safeParse(resultPost);

  if (validationResult.error) {
    validationResult.error.issues.forEach((er) => {
      const field = er.path[0] as string;
      formErrors.value[field] = er.message;
    })
    return;
  }

  const method: string = props.editedPost ? 'PUT' : 'POST';
  const path: string = props.editedPost ? '/api/admin/blog/posts/' + props.editedPost.id : '/api/admin/blog/posts';
  $fetch(path, {method: method, body: resultPost, headers: { Accept: "application/json"}})
  toast.add({ title: 'Success', description: 'The form has been submitted.', color: 'success' });
  navigateTo('/blog/postsUI');
}

watch(() => props.editedPost, (editedPost) => { console.log(editedPost);
  if (props.editedPost) {
    post.value = {
      title: props.editedPost.title,
      content_raw: props.editedPost.content,
      category_id: props.editedPost.category_id,
      category_title: props.editedPost.category_title,
      is_published: props.editedPost.is_published
    };
  }
}, {immediate: true});

getCategories();
</script>

<template>
  <div>
    <UForm @submit="handleSubmit">
      <div class="flex gap-2">
        <div class="w-[70%] min-h-128 h-auto p-2 border-gray-300 border-2 rounded-xl overflow-hidden shadow-sm mb-4">
          <UFormField label="Title" required :ui="{label: 'text-lg font-semibold'}" class="mb-4" :error="formErrors['title']">
            <UInput name="title" placeholder="My first post" class="w-full text-md" v-model="post.title" size="xl"/>
          </UFormField>

          <UFormField label="Content" required :error="formErrors['content_raw']">
            <UTextarea name="content_raw" class="w-full" :rows="22" autoresize v-model="post.content_raw" />
          </UFormField>
        </div>
        <div class="w-[30%] p-2 h-fit border-gray-300 border-2 rounded-xl overflow-hidden shadow-sm mb-4">
          <UFormField name="category_id" label="Category" required :ui="{label: 'text-lg font-semibold'}" class="mb-4" :error="formErrors['category_id']">
            <USelectMenu v-model="post.category_title" valueKey="label" :items="selectMenuCategories" class="w-full"/>
          </UFormField>

          <UFormField label="Published" orientation="horizontal" :ui="{label: 'text-lg font-semibold'}">
            <UCheckbox v-model="post.is_published"/>
          </UFormField>

          <UButton type="submit" :label="editedPost ? 'Update post' : 'Create post'" block class="w-full text-center mt-8"/>
        </div>
      </div>
    </UForm>
  </div>
</template>

<style scoped>

</style>
