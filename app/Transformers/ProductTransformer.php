<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Product;

class ProductTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'identifier' => (int)$product->id,
            'title' => (string)$product->name,
            'details' => (string)$product->description,
            'situation' => (string)$product->status,
            'stock' => (int)$product->quantity,
            'seller' => (int)$product->seller_id,
            'picture' => url("img/{$product->image}"),
            'dateCreate' => (string)$product->created_at,
            'dateLastUpdated' => (string)$product->updated_at,
            'dateDeleted' => isset($product->deleted_at) ? (string)$product->deleted_at : null
        ];
    }

    public static function originalAtrribute($index)
    {
        $attributes = [
            'identifier' => 'id',
            'title' => 'name',
            'details' => 'description',
            'situation' => 'status',
            'stock' => 'quantity',
            'seller' => 'seller_id',
            'picture' => 'image',
            'dateCreate' => 'created_at',
            'dateLastUpdated' => 'updated_at',
            'dateDeleted' => 'deleted_at'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
