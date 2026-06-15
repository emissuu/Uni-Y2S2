<script setup lang="ts">
</script>
<template>
  <UDropdownMenu
    v-slot="{ open }"
    :modal="false"
    :items="[{
      label: 'Starter',
      to: 'https://starter-template.nuxt.dev/',
      color: 'primary',
      checked: true,
      type: 'checkbox'
    }, {
      label: 'Landing',
      to: 'https://landing-template.nuxt.dev/'
    }, {
      label: 'Docs',
      to: 'https://docs-template.nuxt.dev/'
    }, {
      label: 'SaaS',
      to: 'https://saas-template.nuxt.dev/'
    }, {
      label: 'Dashboard',
      to: 'https://dashboard-template.nuxt.dev/'
    }, {
      label: 'Chat',
      to: 'https://chat-template.nuxt.dev/'
    }, {
      label: 'Portfolio',
      to: 'https://portfolio-template.nuxt.dev/'
    }, {
      label: 'Changelog',
      to: 'https://changelog-template.nuxt.dev/'
    }]"
    :content="{ align: 'start' }"
    :ui="{ content: 'min-w-fit' }"
    size="xs"
  >
    <UButton
      label="Starter"
      variant="subtle"
      trailing-icon="i-lucide-chevron-down"
      size="xs"
      class="-mb-[6px] font-semibold rounded-full truncate"
      :class="[open && 'bg-primary/15']"
      :ui="{
        trailingIcon: ['transition-transform duration-200', open ? 'rotate-180' : undefined].filter(Boolean).join(' ')
      }"
    />
  </UDropdownMenu>
  <div class="flex gap-4 font-semibold mt-1 mx-3 underline">
    <a href="/products">Products</a>
    <a href="/table">Table</a>
    <div class="w-[1.5px] -my-0.5 -mx-2 bg-slate-500" />
    <a href="/blog/postsUI">Blog</a>
    <a href="/admin/blog/categories">Categories</a>
  </div>
</template>
