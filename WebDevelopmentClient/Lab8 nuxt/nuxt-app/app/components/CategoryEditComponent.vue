<script setup lang="ts">
import type {Category} from "~/types/blog";
import type {SelectMenuItem} from "@nuxt/ui/components/SelectMenu.vue";
import { z } from "zod";

const props = defineProps<{
  editedCategory: Category | null
}>();

const formErrors = ref<Record<string,string>>({});

const category = ref({
  title:  "",
  parent_id:  0,
  parent_title:  "",
  description: "",
});

const selectMenuCategories = ref<SelectMenuItem[]>();

const getCategories = () => {
  $fetch<{ data: Category[] }>('/api/admin/blog/categories', { query: { per_page: 50}})
    .then((res) => {
      if (!category.value.parent_id && res.data && res.data[0]) {
        category.value.parent_id = res.data[0].id;
        category.value.parent_title = res.data[0].title;
      }
      selectMenuCategories.value = res.data.map((c) => {
        return {
          label: c.title,
          onSelect: () => {category.value.parent_id = c.id}
        }
      })
    })
}

const categorySchema = z.object({
  title: z.string()
    .min(5, 'Title must be at least 5 characters long')
    .max(200, 'Title cannot be longer than 200 characters'),
  parent_id: z.number('Parent category is required' ),
  description: z.string()
    .min(3, 'The description must be at least 3 characters long')
    .max(500, 'Description cannot be longer than 500 characters')
})

const toast = useToast()

const handleSubmit = () => {
  formErrors.value = {};
  const resultCategory = {
    title: category.value.title,
    parent_id: category.value.parent_id,
    description: category.value.description,
  };
  const validationResult = categorySchema.safeParse(resultCategory);

  if (validationResult.error) {
    validationResult.error.issues.forEach((er) => {
      const field = er.path[0] as string;
      formErrors.value[field] = er.message;
    })
    return;
  }

  const method: string = props.editedCategory ? 'PUT' : 'POST';
  const path: string = props.editedCategory ? '/api/admin/blog/categories/' + props.editedCategory.id : '/api/admin/blog/categories';
  $fetch(path, {method: method, body: resultCategory, headers: { Accept: "application/json"}})
  toast.add({ title: 'Success', description: 'The form has been submitted.', color: 'success' });
  navigateTo('/admin/blog/categories');
}

watch(() => props.editedCategory, (editedCategory) => { console.log(editedCategory);
  if (props.editedCategory) {
    category.value = {
      title: props.editedCategory.title,
      parent_id:  props.editedCategory.parent_id,
      parent_title:  props.editedCategory.parent_title,
      description: props.editedCategory.description,
    };
  }
}, {immediate: true});

getCategories();
</script>

<template>
  <div>
    <UForm @submit="handleSubmit">
      <div class="p-2 h-fit">
        <UFormField label="Title" required :ui="{label: 'text-lg font-semibold'}" class="mb-4" :error="formErrors['title']">
          <UInput name="title" placeholder="My category" class="w-full text-md" v-model="category.title" size="xl"/>
        </UFormField>

        <UFormField name="parent_id" label="Parent category" required :ui="{label: 'text-lg font-semibold'}" class="mb-4" :error="formErrors['parent_id']">
          <USelectMenu v-model="category.parent_title" valueKey="label" :items="selectMenuCategories" class="w-full"/>
        </UFormField>

        <UFormField label="Description" :error="formErrors['description']">
          <UTextarea name="content_raw" class="w-full" :rows="4" autoresize v-model="category.description" />
        </UFormField>

        <UButton type="submit" :label="editedCategory ? 'Update category' : 'Create category'" block class="w-full text-center mt-4"/>
      </div>
    </UForm>
  </div>
</template>

<style scoped>

</style>
