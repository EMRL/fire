<?php

namespace Fire\Model\Post;

use Fire\Model\Repository;
use Fire\Foundation\Collection;
use Fire\Contracts\Foundation\Arrayable;
use Fire\Contracts\Model\Post\Post as PostContract;
use Fire\Contracts\Model\EntityMapper as EntityMapperContract;

class PostRepository extends Repository {

	protected $postType;

	protected $entityClass = 'Fire\Model\Post\Post';

	/**
	 * @var  Fire\Contracts\Model\Post\Post
	 */
	protected $currentPost;

	public function __construct(EntityMapperContract $entityMapper, $postType)
	{
		parent::__construct($entityMapper);

		$this->postType = $postType;
	}

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

	public function find($args = null)
	{
		if (is_null($args))
		{
			$args = $this->newParams();
		}

		$args = ($args instanceof Arrayable) ? $args->toArray() : $args;

		$posts = new Collection;

		foreach (get_posts($args) as $post)
		{
			$posts->push($this->postOfId($post->ID));
		}

		return $posts;
	}

	public function currentPost()
	{
		return $this->currentPost;
	}

	public function setCurrentPost(PostContract $post)
	{
		$this->currentPost = $post;
	}

	protected function newParams()
	{
		return new PostParams($this->postType);
	}

	public function setPostType($type)
	{
		$this->postType = $type;
	}

}