<?php

namespace Fire\Model\User;

use Fire\Model\Repository;
use Fire\Foundation\Collection;

class UserRepository extends Repository {

	protected $entityClass = 'Fire\Model\User\User';

	public function userOfId($id)
	{
		$user = get_user_by('id', $id);

		if ($user)
		{
			$user = $this->mapData($user->to_array());
		}

		return $user;
	}

	public function userOfUsername($username)
	{
		$user = get_user_by('login', $username);

		if ($user)
		{
			$user = $this->mapData($user->to_array());
		}

		return $user;
	}

	public function userOfEmail($email)
	{
		$user = get_user_by('email', $email);

		if ($user)
		{
			$user = $this->mapData($user->to_array());
		}

		return $user;
	}

	public function find(array $args = [])
	{
		$users = new Collection;

		foreach (get_users($args) as $user)
		{
			$users->push($this->userOfId($user->ID));
		}

		return $users;
	}

}