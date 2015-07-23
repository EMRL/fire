<?php

namespace Fire\Model\Page;

use Fire\Model\Post\PostRepository;

class PageRepository extends PostRepository {

	protected $entityClass = 'Fire\Model\Page\Page';

	public function pageOfId($id)
	{
		return $this->postOfId($id);
	}

	public function pageOfSlug($slug)
	{
		return $this->postOfSlug($slug);
	}

	protected function newParams()
	{
		return new PageParams($this->postType);
	}

}