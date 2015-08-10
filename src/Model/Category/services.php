<?php

use Fire\Model\Term\TermEntityMapper;
use Fire\Model\Category\CategoryRepository;
use Fire\Model\Category\CategoryEntityMapper;
use Fire\Model\Category\CategoryTaxonomy;

add_action('fire/services', function($fire)
{
	$fire->singleton('category.repository', function($fire)
	{
		$repo = new CategoryRepository(CategoryTaxonomy::NAME);

		$repo->registerEntityMapper(function()
		{
			return new TermEntityMapper;
		});

		$repo->registerEntityMapper(function() use ($fire)
		{
			return new CategoryEntityMapper(
				$fire['category.repository'],
				$fire['post.repository']
			);
		});

		return $repo;
	});
}, 5);