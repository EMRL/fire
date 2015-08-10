<?php

use Fire\Model\AbstractPost\AbstractPostEntityMapper;
use Fire\Model\Post\PostRepository;
use Fire\Model\Post\PostEntityMapper;
use Fire\Model\Post\PostPostType;

add_action('fire/services', function($fire)
{
	$fire->singleton('post.repository', function($fire)
	{
		$repo = new PostRepository(PostPostType::TYPE);

		$repo->registerEntityMapper(function() use ($fire)
		{
			return new AbstractPostEntityMapper($fire['user.repository']);
		});

		$repo->registerEntityMapper(function() use ($fire)
		{
			return new PostEntityMapper(
				$fire['post.repository'],
				$fire['category.repository'],
				$fire['tag.repository']
			);
		});

		return $repo;
	});
}, 5);