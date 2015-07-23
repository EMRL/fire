<?php

namespace Fire\Model\Post;

use Fire\Foundation\Params;

class PostParams extends Params {

	protected $postType;

	public function __construct($postType)
	{
		$this->postType = $postType;
	}

	protected function defaultParams()
	{
		return [
			'post_type'        => $this->postType,
			'posts_per_page'   => -1,
			'suppress_filters' => false,
		];
	}

}