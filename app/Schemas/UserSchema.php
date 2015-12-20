<?php namespace App\Schemas;

use \App\User;
use \Neomerx\JsonApi\Schema\SchemaProvider;

/**
 * @package Neomerx\LimoncelloShot
 */
class UserSchema extends SchemaProvider
{
    /**
     * @inheritdoc
     */
    protected $resourceType = 'users';

    /**
     * @inheritdoc
     */
    protected $selfSubUrl = '/users/';

    /**
     * @inheritdoc
     */
    public function getId($user)
    {
        /** @var User $user */
        return $user->id;
    }

    /**
     * @inheritdoc
     */
    public function getAttributes($user)
    {
        /** @var User $user */
        return [
            'exists' => isset($user->email),
        ];
    }
}
