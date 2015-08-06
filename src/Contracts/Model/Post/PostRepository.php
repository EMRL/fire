<?php

namespace Fire\Contracts\Model\Post;

interface PostRepository {

	public function postOfId($id);

	public function postOfSlug($slug);

	public function find($args = null);

}