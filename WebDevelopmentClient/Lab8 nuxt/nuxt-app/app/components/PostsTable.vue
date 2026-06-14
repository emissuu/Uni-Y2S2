<script setup lang="ts">
import type {Post} from "~/types/blogPost";

const posts = ref<Post[]>([]),
  getPosts = () => {
  $fetch<{ current_page: number, data: Post[] }>('/api/blog-posts')
    .then(response => {
      console.log("Received " + response.data.length + " posts");
      posts.value = response.data;
    });
};

getPosts();
</script>

<template>
  <div class="container">
    <div class="flex justify-center">
      <div class="w-full">
        <nav class="navbar bg-gray-100">
          <a href="/admin/blog/posts/create" class="">Додати</a>
        </nav>

        <div class="card">
          <div class="card-body">
            <table class="table table-auto">
              <thead>
              <tr>
                <th>#</th>
                <th>Автор</th>
                <th>Категорія</th>
                <th>Заголовок</th>
                <th>Дата публікації</th>
              </tr>
              </thead>

              <tbody>
              <tr v-for="post in posts">
                <td>{{ post.id }}</td>
                <td>{{ post.author_name }}</td>
                <td>{{ post.category_title }}</td>
                <td><a :href="'/blog/posts/' + post.slug">{{ post.title }}</a></td>
                <td>{{ post.date_published }}
                </td>
              </tr>
              </tbody>

            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

</template>

<style scoped>

</style>
