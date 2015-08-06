<?php

namespace Fire\Model;

use Fire\Model\User\UserRepository;
use Fire\Model\User\UserEntityMapper;
use Fire\Model\Post\PostRepository;
use Fire\Model\Post\PostEntityMapper;
use Fire\Model\Post\PostPostType;
use Fire\Model\Page\PageRepository;
use Fire\Model\Page\PageEntityMapper;
use Fire\Model\Page\PagePostType;
use Fire\Model\Category\CategoryRepository;
use Fire\Model\Category\CategoryEntityMapper;
use Fire\Model\Category\CategoryTaxonomy;
use Fire\Model\Tag\TagRepository;
use Fire\Model\Tag\TagEntityMapper;
use Fire\Model\Tag\TagTaxonomy;

add_action('fire/services', function($fire)
{
	$fire->singleton('repository.user', function($fire)
	{
		return new UserRepository(new UserEntityMapper);
	});

	$fire->singleton('repository.'.PostPostType::TYPE, function($fire)
	{
		return new PostRepository(
			new PostEntityMapper($fire['repository.user']),
			PostPostType::TYPE
		);
	});

	$fire->singleton('repository.'.PagePostType::TYPE, function($fire)
	{
		return new PageRepository(
			new PageEntityMapper($fire['repository.user']),
			PagePostType::TYPE
		);
	});

	$fire->singleton('repository.'.CategoryTaxonomy::NAME, function($fire)
	{
		return new CategoryRepository(
			new CategoryEntityMapper($fire['repository.'.PostPostType::TYPE]),
			CategoryTaxonomy::NAME
		);
	});

	$fire->singleton('repository.'.TagTaxonomy::NAME, function($fire)
	{
		return new TagRepository(
			new TagEntityMapper($fire['repository.'.PostPostType::TYPE]),
			TagTaxonomy::NAME
		);
	});
});