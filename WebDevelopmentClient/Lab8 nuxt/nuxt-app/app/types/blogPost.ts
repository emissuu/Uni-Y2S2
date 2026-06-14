export interface Post {
  id: number,
  category_id: number,
  category_title: string,
  author_id: number,
  author_name: string,
  author_image_url: string,
  slug: string,
  title: string,
  content: string,
  is_published: boolean,
  date_published: string,
  date_updated: string,
}
