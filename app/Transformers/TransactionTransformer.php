<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Transaction;

class TransactionTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Transaction $transaction)
    {
        return [
            'identifier' => (int)$transaction->id,
            'quantity' => (int)$transaction->quantity,
            'buyer' => (int)$transaction->buyer_id,
            'product' => (int)$transaction->product_id,
            'dateCreate' => (string)$transaction->created_at,
            'dateLastUpdated' => (string)$transaction->updated_at,
            'dateDeleted' => isset($transaction->deleted_at) ? (string)$transaction->deleted_at : null,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('transactions.show', $transaction->id)
                ],
                [
                    'rel' => 'transaction.product',
                    'href' => route('products.show', $transaction->product_id)
                ],
                [
                    'rel' => 'transaction.seller',
                    'href' => route('transactions.sellers.index', $transaction->id)
                ],
                [
                    'rel' => 'transaction.categories',
                    'href' => route('transactions.categories.index', $transaction->id)
                ],
                [
                    'rel' => 'transaction.buyer',
                    'href' => route('buyers.show', $transaction->buyer_id)
                ]
            ]
        ];
    }

    public static function originalAtrribute($index)
    {
        $attributes = [
            'identifier' => 'id',
            'quantity' => 'quantity',
            'buyer' => 'buyer_id',
            'product' => 'product_id',
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
            'quantity' => 'quantity',
            'buyer_id' => 'buyer',
            'product_id' => 'product',
            'created_at' => 'dateCreate',
            'updated_at' => 'dateLastUpdated',
            'deleted_at' => 'dateDeleted'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
