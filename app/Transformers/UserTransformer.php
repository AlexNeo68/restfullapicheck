<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\User;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'identifier' => (int)$user->id,
            'name' => (string)$user->name,
            'email' => (string)$user->email,
            'isVerified' => (int)$user->verified,
            'isAdmin' => ($user->admin === 'true'),
            'dateCreate' => (string)$user->created_at,
            'dateLastUpdated' => (string)$user->updated_at,
            'dateDeleted' => isset($user->deleted_at) ? (string)$user->deleted_at : null
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
}
