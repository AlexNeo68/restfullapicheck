<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Seller;

class SellerTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Seller $seller)
    {
        return [
            'identifier' => (int)$seller->id,
            'name' => (string)$seller->name,
            'email' => (string)$seller->email,
            'isVerified' => (int)$seller->verified,
            'dateCreate' => (string)$seller->created_at,
            'dateLastUpdated' => (string)$seller->updated_at,
            'dateDeleted' => isset($seller->deleted_at) ? (string)$seller->deleted_at : null,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('sellers.show', $seller->id)
                ],
                [
                    'rel' => 'seller.products',
                    'href' => route('sellers.products.index', $seller->id)
                ],
                [
                    'rel' => 'seller.buyers',
                    'href' => route('sellers.buyers.index', $seller->id)
                ],
                [
                    'rel' => 'seller.transactions',
                    'href' => route('sellers.transactions.index', $seller->id)
                ],
                [
                    'rel' => 'seller.categories',
                    'href' => route('sellers.categories.index', $seller->id)
                ],
                [
                    'rel' => 'seller.user',
                    'href' => route('users.show', $seller->id)
                ]
            ]
        ];
    }

    public static function originalAtrribute($index)
    {
        $attributes = [
            'identifier' => 'id',
            'name' => 'name',
            'email' => 'email',
            'isVerified' => 'verified',
            'isAdmin' => 'admin',
            'dateCreate' => 'created_at',
            'dateLastUpdated' => 'updated_at',
            'dateDeleted' => 'deleted_at'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAtrribute($index)
    {
        $attributes = [
            'id' => 'identifier',
            'name' => 'name',
            'email' => 'email',
            'verified' => 'isVerified',
            'admin' => 'isAdmin',
            'created_at' => 'dateCreate',
            'updated_at' => 'dateLastUpdated',
            'deleted_at' => 'dateDeleted'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
