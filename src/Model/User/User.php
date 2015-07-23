<?php

namespace Fire\Model\User;

use WP_User;
use Fire\Contracts\Foundation\Arrayable;
use Fire\Contracts\Model\Entity as EntityContract;
use Fire\Contracts\Model\User\User as UserContract;

class User extends WP_User implements EntityContract, UserContract, Arrayable {

	public function id()
	{
		return $this->ID;
	}

	public function username()
	{
		return $this->user_login;
	}

	public function email()
	{
		return $this->user_email;
	}

	public function url()
	{
		return $this->user_url;
	}

	public function firstName()
	{
		return $this->first_name;
	}

	public function lastName()
	{
		return $this->last_name;
	}

	public function fullName()
	{
		return $this->firstName().' '.$this->lastName();
	}

	public function nickname()
	{
		return $this->nickname;
	}

	public function displayName()
	{
		return $this->display_name;
	}

	public function toArray()
	{
		return $this->to_array();
	}

}