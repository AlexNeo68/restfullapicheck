<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Category;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            'identifier' => (int)$category->id,
            'title' => (string)$category->name,
            'details' => (string)$category->description,
            'dateCreate' => (string)$category->created_at,
            'dateLastUpdated' => (string)$category->updated_at,
            'dateDeleted' => isset($category->deleted_at) ? (string)$category->deleted_at : null
        ];
    }
}
