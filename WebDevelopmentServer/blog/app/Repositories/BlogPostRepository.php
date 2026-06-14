<?php

namespace App\Repositories;

use App\Models\BlogPost as Model;
use Illuminate\Database\Eloquent\Collection;
use phpDocumentor\Reflection\PseudoTypes\Numeric_;

/**
 * Class BlogСategoryRepository.
 */
class BlogPostRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class; //абстрагування моделі BlogCategory, для легшого створення іншого репозиторія
    }

    /**
     * Отримати список статей
     * @param int $per_page
     * @param string filter
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllWithPaginate($per_page, $filter)
    {
        $columns = ['id', 'title', 'slug', 'is_published', 'published_at', 'user_id', 'category_id',];

        $result = $this->startConditions()
            ->select($columns);

        if (!empty($filter)) {
            $result = $result
                ->where('slug', 'like', '%' . $filter . '%')
                ->orWhere('excerpt', 'like', '%' . $filter . '%')
                ->orWhere('content_raw', 'like', '%' . $filter . '%');
        }

        $result = $result
            ->orderBy('id','DESC')
            ->with([
                'category' => function ($query) {
                    $query->select(['id', 'title']);
                },
                //'category:id,title',
                'user:id,name',
            ])
            ->paginate($per_page);

        return $result;
    }
    /**
     * Отримати модель за слагом
     * @param string $slug
     * @return Model
     */
    public function getBySlug($slug)
    {
        $columns = ['id', 'title', 'slug', 'is_published', 'published_at', 'created_at', 'updated_at', 'user_id', 'category_id', 'excerpt', 'content_html', 'content_raw'];

        $result = $this->startConditions()
            ->select($columns)
            ->with([
                'category' => function ($query) {
                    $query->select(['id', 'title']);
                },
                'user:id,name',
            ])
            ->where('slug', $slug)
        ->first();

        return $result;
    }

    /**
     *  Отримати модель для редагування в адмінці
     *  @param int $id
     *  @return Model
     */
    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }
}
