<?php

use Fire\Model\AbstractPost\AbstractPostEntityMapper;
use Fire\Model\Upload\UploadRepository;
use Fire\Model\Upload\UploadEntityMapper;
use Fire\Model\Upload\UploadPostType;

add_action('fire/services', function($fire)
{
	$fire->singleton('upload.repository', function($fire)
	{
		$repo = new UploadRepository(UploadPostType::TYPE);

		$repo->registerEntityMapper(function() use ($fire)
		{
			return new AbstractPostEntityMapper($fire['user.repository']);
		});

		$repo->registerEntityMapper(function() use ($fire)
		{
			return new UploadEntityMapper;
		});

		return $repo;
	});
}, 5);