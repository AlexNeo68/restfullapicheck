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
            'dateDeleted' => isset($seller->deleted_at) ? (string)$seller->deleted_at : null
        ];
    }
}
