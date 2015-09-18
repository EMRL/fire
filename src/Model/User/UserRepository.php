<?php

namespace Fire\Model\User;

use Fire\Model\Repository;
use Fire\Foundation\Collection;
use Fire\Contracts\Model\User\UserRepository as UserRepositoryContract;

class UserRepository extends Repository implements UserRepositoryContract
{
    protected $entityClass = 'Fire\Model\User\User';

    public function userOfId($id)
    {
        $user = get_user_by('id', $id);

        if ($user) {
            $user = $this->mapData($user->to_array());
        }

        return $user;
    }

    public function userOfUsername($username)
    {
        $user = get_user_by('login', $username);

        if ($user) {
            $user = $this->mapData($user->to_array());
        }

        return $user;
    }

    public function userOfEmail($email)
    {
        $user = get_user_by('email', $email);

        if ($user) {
            $user = $this->mapData($user->to_array());
        }

        return $user;
    }

    public function find($args = null)
    {
        if (is_null($args) or is_array($args)) {
            $defaults = $this->newParams();
            $defaults = ($defaults instanceof Arrayable) ? $defaults->toArray() : $defaults;
            $args     = is_array($args) ? array_merge_recursive($defaults, $args) : $defaults;
        }

        $args = ($args instanceof Arrayable) ? $args->toArray() : $args;

        $users = new Collection;

        foreach (get_users($args) as $user) {
            $users->push($this->userOfId($user->ID));
        }

        return $users;
    }

    public function newParams()
    {
        return new UserParams;
    }
}
