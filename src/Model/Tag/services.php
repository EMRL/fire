<?php

use Fire\Model\Term\TermEntityMapper;
use Fire\Model\Tag\TagRepository;
use Fire\Model\Tag\TagEntityMapper;
use Fire\Model\Tag\TagTaxonomy;

add_action('fire/services', function($fire)
{
	$fire->singleton('tag.repository', function($fire)
	{
		$repo = new TagRepository(TagTaxonomy::NAME);

		$repo->registerEntityMapper(function()
		{
			return new TermEntityMapper;
		});

		$repo->registerEntityMapper(function() use ($fire)
		{
			return new TagEntityMapper(
				$fire['tag.repository'],
				$fire['post.repository']
			);
		});

		return $repo;
	});
}, 5);