<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Buyer;

class BuyerTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Buyer $buyer)
    {
        return [
            'identifier' => (int)$buyer->id,
            'name' => (string)$buyer->name,
            'email' => (string)$buyer->email,
            'isVerified' => (int)$buyer->verified,
            'dateCreate' => (string)$buyer->created_at,
            'dateLastUpdated' => (string)$buyer->updated_at,
            'dateDeleted' => isset($buyer->deleted_at) ? (string)$buyer->deleted_at : null,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('buyers.show', $buyer->id)
                ],
                [
                    'rel' => 'buyer.products',
                    'href' => route('buyers.products.index', $buyer->id)
                ],
                [
                    'rel' => 'buyer.sellers',
                    'href' => route('buyers.sellers.index', $buyer->id)
                ],
                [
                    'rel' => 'buyer.transactions',
                    'href' => route('buyers.transactions.index', $buyer->id)
                ],
                [
                    'rel' => 'buyer.categories',
                    'href' => route('buyers.categories.index', $buyer->id)
                ],
                [
                    'rel' => 'buyer.user',
                    'href' => route('users.show', $buyer->id)
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
