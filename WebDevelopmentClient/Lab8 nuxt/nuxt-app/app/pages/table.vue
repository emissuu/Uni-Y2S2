<script setup lang="ts">
import type {ProductTable} from "~/types/productTable";

const { data: products, status } = await useLazyFetch<ProductTable[]>('/api/product-table')

useSeoMeta({
  title: 'Products Table',
  description: 'Table of products is here..'
})
</script>

<template>
  <div class="flex justify-center mb-16">
    <ProductTable
                 :products="products"
                 :status="status"
                  class="shadow-md"/>
  </div>
</template>
