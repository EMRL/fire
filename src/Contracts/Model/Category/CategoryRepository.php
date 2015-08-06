<?php

namespace Fire\Contracts\Model\Category;

interface CategoryRepository {

	public function categoryOfId($id);

	public function categoryOfSlug($slug);

	public function find($args = null);

}