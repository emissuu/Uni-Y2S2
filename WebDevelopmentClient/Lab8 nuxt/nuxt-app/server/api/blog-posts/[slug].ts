export default defineEventHandler((event) => {
  const slug = getRouterParam(event, 'slug');
  return $fetch('http://localhost/api/blog/posts/' + slug);
})
