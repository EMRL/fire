<?php

namespace Fire\Contracts\Model\User;

interface UserRepository {

	public function userOfId($id);

	public function userOfUsername($username);

	public function userOfEmail($email);

	public function find($args = []);

}