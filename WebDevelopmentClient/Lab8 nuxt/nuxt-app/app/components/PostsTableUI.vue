<script setup lang="ts">
import type {Post} from "~/types/blog";
import type {TableColumn} from "@nuxt/ui/components/Table.vue";
import type {DropdownMenuItem} from "@nuxt/ui/components/DropdownMenu.vue";
import {refDebounced} from "@vueuse/shared";
import {UDropdownMenu} from "#components";


const totalEntries = ref(0);
const posts = ref<Post[]>([]);
const currentPage = ref(1);
const perPage = ref(25);
const filter = ref("");
const filterDebounced = refDebounced(filter, 500)
const sorting = ref([{ id: 'id', desc: true }])

const getPosts = () => {
  const queries: Record<string, any> = {
    page: currentPage.value,
    per_page: perPage.value
  };
  if (filter.value) queries['filter'] = filter.value;
  $fetch<{ meta: { current_page: number, total: number }, data: Post[] }>('/api/blog/posts', { query: queries })
    .then(response => {
      totalEntries.value = response.meta.total;
      posts.value = response.data;

      // debug
      console.log("Received " + response.data.length + " posts");
      console.log("Displaying " + posts.value.length + " posts");
    });
};

const columns: TableColumn<Post>[] = [
  {
    accessorKey: "id",
    header: "#",
    meta: {class: {td: "w-[5%]"}}
  },
  {
    accessorKey: "author_name",
    header: "Автор",
    meta: {class: {td: "w-[15%]"}}
  },
  {
    accessorKey: "category_title",
    header: "Категорія",
    meta: {class: {td: "w-[15%]"}}
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
    },
    meta: {class: {td: "w-[50%]"}}
  },

  {
    accessorKey: "date_published",
    header: "Дата публікації",
    cell: ({row}) => {
      const date: string = row.getValue("date_published");
      return date ?
        `${(new Date(row.getValue("date_published"))).toLocaleDateString()}` :
        ""
    },
    meta: {class: {td: "w-[10%]"}}
  },
  {
    accessorKey: 'id',
    header: " ",
    cell: ({row}) => h(
      UDropdownMenu,
      {
        items: getAdminOptions(row.original.id, row.original.slug),
      },
      h(
        UButton, {
          variant: 'ghost', color: 'neutral',
          class: 'w-8 rounded-xl hover:bg-gray-200',
          icon: 'i-lucide-ellipsis-vertical'
        }
      )
    ),
    meta: {class: {td: "w-[5%]"}}
  }
]

const handleDelete = (id: number) => {
  $fetch(`/api/admin/blog/posts/${id}`, { method: 'DELETE', })
    .then(response => {
      getPosts();
    });
}

const getAdminOptions = (id: number, slug: string): DropdownMenuItem[]  => [
  {
    label: 'Edit',
    color: 'neutral',
    icon: 'i-lucide-square-pen',
    onClick: () => navigateTo(`/admin/blog/posts/${slug}/edit`)
  },
  {
    label: 'Delete',
    icon: 'i-lucide-trash',
    color: 'error',
    onClick: () => handleDelete(id)
  }
];

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
];

watch([filterDebounced], () => {
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

        <nav class="navbar bg-gray-100 border-b border-gray-300">
          <div class="flex justify-between">
            <div class="flex items-center">
              <UInput v-model="filter" class="max-w-sm p-2" placeholder="Filter" />
              <p class="ml-2" >Page:</p>
              <UPagination
                class="p-2"
                :total="totalEntries"
                :page="currentPage"
                :items-per-page="perPage"
                @update:page="(page) => {currentPage = page}"
              />
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
          :ui="{
            td: 'whitespace-normal',
            thead: 'bg-gray-100 text-gray-500',
            tr: 'bg-gray-0 hover:bg-gray-100 transition-colors'
          }"/>

        <footer class="footer bg-gray-100 border-t border-gray-300">
          <div class="flex justify between">
            <div>
              <p class="m-3 text-base" >{{
                  !filter || filter.length == 0 ? 'Total entries:' : 'Total entries matching filter:'
                }} {{ totalEntries }}</p>
            </div>
          </div>
        </footer>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
