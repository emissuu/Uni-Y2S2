<script setup lang="ts">
import {refDebounced} from "@vueuse/shared";
import type {TableColumn} from "@nuxt/ui/components/Table.vue";
import type {Category} from "~/types/blog";
import type {DropdownMenuItem} from "@nuxt/ui/components/DropdownMenu.vue";
import {UDropdownMenu} from "#components";

const totalEntries = ref(0);
const categories = ref<Category[]>([]);
const currentPage = ref(1);
const perPage = ref(10);
const filter = ref("");
const filterDebounced = refDebounced(filter, 500)
const sorting = ref([{ id: 'id', desc: true }])

const getCategories = () => {
  const queries: Record<string, any> = {
    page: currentPage.value,
    per_page: perPage.value
  };
  if (filter.value) queries['filter'] = filter.value;
  $fetch<{ meta: { current_page: number, total: number }, data: Category[] }>('/api/admin/blog/categories', { query: queries })
    .then(response => {
      totalEntries.value = response.meta.total;
      categories.value = response.data;
    });
}

const columns: TableColumn<Category>[] = [
  {
    accessorKey: "id",
    header: "#",
    meta: {class: {td: "w-[5%]"}}
  },
  {
    accessorKey: "title",
    header: "Назва",
    meta: {class: {td: "w-[15%]"}}
  },
  {
    accessorKey: "parent_title",
    header: "Батьківська категорія",
    meta: {class: {td: "w-[15%]"}}
  },
  {
    accessorKey: "description",
    header: "Опис",
    meta: {class: {td: "w-[50%]"}}
  },
  {
    accessorKey: "date_updated",
    header: "Останнє оновлення",
    cell: ({row}) => `${(new Date(row.getValue("date_updated"))).toLocaleDateString() || ""}`,
    meta: {class: {td: "w-[10%]"}}
  },
  {
    accessorKey: 'id',
    header: " ",
    cell: ({row}) => h(
      UDropdownMenu,
      {
        items: getAdminOptions(row.original.id)
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
];

const handleDelete = (id: number) => {
  $fetch(`/api/admin/blog/categories/${id}`, { method: 'DELETE', })
    .then(response => {
      getCategories();
    });
}

const getAdminOptions = (id: number): DropdownMenuItem[]  => [
  {
    label: 'Edit',
    color: 'neutral',
    icon: 'i-lucide-square-pen',
    onClick: () => navigateTo(`/admin/blog/categories/${id}/edit`)
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
    label: '20',
    onSelect: () => {perPage.value = 20},
  },
  {
    label: '50',
    onSelect: () => {perPage.value = 10},
  }
];

watch([filterDebounced], () => {
  currentPage.value = 1;
  getCategories();
})

watch([perPage, currentPage], () => {
  getCategories();
})

getCategories();
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
              <a href="/admin/blog/categories/create" class="decoration-skip-ink underline underline-offset-4">Додати</a>
            </div>
          </div>
        </nav>

        <UTable
          ref="table"
          :data="categories"
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
