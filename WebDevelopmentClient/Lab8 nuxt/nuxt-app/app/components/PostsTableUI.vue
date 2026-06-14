<script setup lang="ts">
import type {Post} from "~/types/blogPost";
import type {TableColumn} from "@nuxt/ui/components/Table.vue";
import type {DropdownMenuItem} from "@nuxt/ui/components/DropdownMenu.vue";


const totalEntries = ref(0);
const posts = ref<Post[]>([]);
const currentPage = ref(1);
const perPage = ref(25);
const globalFilter = ref ("");
const sorting = ref([{ id: 'id', desc: true }])

const getPosts = () => {
  const queries: Record<string, any> = {
    page: currentPage.value,
    per_page: perPage.value
  };
  if (globalFilter.value) queries['filter'] = globalFilter.value;
  $fetch<{ current_page: number, data: Post[], total: number }>('/api/blog-posts', { query: queries })
    .then(response => {
      console.log("Received " + response.data.length + " posts");
      totalEntries.value = response.total;
      posts.value = response.data;
    });
};

const columns: TableColumn<Post>[] = [
  {
    accessorKey: "id",
    header: "#"
  },
  {
    accessorKey: "author_name",
    header: "Автор"
  },
  {
    accessorKey: "category_title",
    header: "Категорія"
  },
  {
    accessorKey: "title",
    header: "Заголовок",
    cell: ({ row }) => {
      const title: string = row.getValue("title");
      return h('a',
        {
          href: `/blog/posts/${row.original.slug}`,
          class: 'underline'
        },
        title)
    }
  },
  {
    accessorKey: "date_published",
    header: "Дата публікації",
    cell: ({row}) => `${(new Date(row.getValue("date_published"))).toLocaleDateString() || ""}`
  }
]

const perPageOptions: DropdownMenuItem[] = [
  {
    label: '5',
    onSelect: () => {perPage.value = 5},
  },
  {
    label: '10',
    onSelect: () => {perPage.value = 10},
  },
  {
    label: '25',
    onSelect: () => {perPage.value = 25},
  },
  {
    label: '100',
    onSelect: () => {perPage.value = 100},
  },
]

watch([globalFilter], () => {
  currentPage.value = 1;
  getPosts();
})

watch([perPage, currentPage], () => {
  getPosts();
})

getPosts();
</script>

<template>
  <div class="container">
    <div class="flex justify-center">
      <div class="w-full">

        <nav class="navbar bg-gray-100 border-b-1 border-gray-300">
          <div class="flex justify-between">
            <div class="flex items-center">
              <UInput v-model="globalFilter" class="max-w-sm p-2" placeholder="Filter" />
              <p class="ml-2" >Page:</p>
              <UInput v-model="currentPage" class="max-w-16 p-2" />
              <p class="ml-2" >Per page:</p>
              <UDropdownMenu
                :items="perPageOptions"
                :ui="{ content: 'min-w-2 w-20' }"
                class="m-2">
                <UButton
                  :label="perPage.toString()"
                  color="neutral"
                  variant="outline"
                  class="w-20"
                  block
                  trailing-icon="i-lucide-chevron-down"
                />
              </UDropdownMenu>
            </div>
            <div class="flex pr-4 items-center">
              <a href="/admin/blog/posts/create" class="decoration-skip-ink underline underline-offset-4">Додати</a>
            </div>
          </div>
        </nav>

        <UTable
          ref="table"
          :data="posts"
          :columns="columns"
          v-model:sorting="sorting"
          v-model:global-filter="globalFilter"
          :ui="{
            td: 'whitespace-normal',
            thead: 'bg-gray-100 text-gray-500',
            tr: 'bg-gray-0 hover:bg-gray-100 transition-colors'
          }"/>

        <footer class="footer bg-gray-100 border-t-1 border-gray-300">
          <div class="flex justify between">
            <div>
              <p class="m-3 text-base" >Total entries: {{totalEntries}}</p>
            </div>
          </div>
        </footer>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
