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
}
