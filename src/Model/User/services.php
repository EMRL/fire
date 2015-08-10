<?php

use Fire\Model\User\UserRepository;
use Fire\Model\User\UserEntityMapper;

add_action('fire/services', function($fire)
{
	$fire->singleton('user.repository', function($fire)
	{
		$repo = new UserRepository;

		$repo->registerEntityMapper(function() use ($fire)
		{
			return new UserEntityMapper;
		});

		return $repo;
	});
}, 5);