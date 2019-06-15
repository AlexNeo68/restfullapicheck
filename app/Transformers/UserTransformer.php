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
            'verification_token' => (string)$user->verification_token,
            'isAdmin' => ($user->admin === 'true'),
            'dateCreate' => (string)$user->created_at,
            'dateLastUpdated' => (string)$user->updated_at,
            'dateDeleted' => isset($user->deleted_at) ? (string)$user->deleted_at : null,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('users.show', $user->id)
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
            'password' => 'password',
            'password_confirmation' => 'password_confirmation',
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
            'password' => 'password',
            'password_confirmation' => 'password_confirmation',
            'created_at' => 'dateCreate',
            'updated_at' => 'dateLastUpdated',
            'deleted_at' => 'dateDeleted'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
