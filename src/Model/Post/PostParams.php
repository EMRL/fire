<?php

namespace Fire\Model\Post;

use Fire\Model\AbstractPost\AbstractPostParams;

class PostParams extends AbstractPostParams {

	public function inCategory($id)
	{
		$this->add([
			'category__in' => (array) $id,
		]);
	}

	public function tagged($id)
	{
		$this->add([
			'tag__in' => (array) $id,
		]);
	}

}