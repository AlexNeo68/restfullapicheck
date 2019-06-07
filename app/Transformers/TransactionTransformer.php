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
            'dateDeleted' => isset($transaction->deleted_at) ? (string)$transaction->deleted_at : null
        ];
    }
}
