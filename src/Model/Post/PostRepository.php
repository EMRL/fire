<?php

namespace Fire\Model\Post;

use Fire\Model\Repository;
use Fire\Foundation\Collection;

class PostRepository extends Repository {

	protected $postType = 'post';

	protected $entityClass = 'Fire\Model\Post\Post';

	public function postOfId($id)
	{
		$post = get_post($id, ARRAY_A);

		if ($post and $post['post_type'] === $this->postType)
		{
			$post = $this->mapData($post);
		}
		else
		{
			$post = null;
		}

		return $post;
	}

	public function postOfSlug($slug)
	{
		$post = get_page_by_path($slug, ARRAY_A, $this->postType);

		if ($post)
		{
			$post = $this->mapData($post);
		}

		return $post;
	}

	public function find(array $args = [])
	{
		$args = array_replace_recursive([
			'post_type'        => $this->postType,
			'posts_per_page'   => -1,
			'suppress_filters' => false,
		], $args);

		$posts = new Collection;

		foreach (get_posts($args) as $post)
		{
			$posts->push($this->postOfId($post->ID));
		}

		return $posts;
	}

}