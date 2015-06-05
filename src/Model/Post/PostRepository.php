<?php

namespace Fire\Model\Post;

use Collection;

class PostRepository extends \Fire\Model\Repository {

	public $entityClass = 'Fire\Model\Post\Post';

	public function postOfId($id)
	{
		$post = get_post($id, ARRAY_A);

		if ($post and $post['post_type'] === PostPostType::TYPE)
		{
			$post = $this->hydrate($post);
		}

		return $post;
	}

	public function postOfSlug($slug)
	{
		$post = get_page_by_path($slug, ARRAY_A, PostPostType::TYPE);

		if ($post)
		{
			$post = $this->hydrate($post);
		}

		return $post;
	}

	public function query(array $args = [])
	{
		$args = array_replace_recursive([
			'post_type'        => 'post',
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

	public function add(Post $post)
	{
		if ($post->id())
		{
			throw new Exception("Can't create a post with an ID already set");
		}

		wp_insert_post($this->transformPost($post));
	}

	public function update(Post $post)
	{
		if ( ! $post->id())
		{
			return $this->add($post);
		}

		$data = $this->transformPost($post);

		$data['ID'] = $post->id();

		wp_update_post($data);
	}

	protected function transformPost($post)
	{
		return [
			'post_type'      => PostPostType::TYPE,
			'post_author'    => $post->author() ? $post->author()->id() : null,
			'post_date'      => $post->date('Y-m-d H:i:s'),
			'post_content'   => $post->content(),
			'post_title'     => $post->title(),
			'post_excerpt'   => $post->excerpt(),
			'post_status'    => $post->status(),
			'comment_status' => $post->commentStatus(),
			'ping_status'    => $post->pingStatus(),
			'post_password'  => $post->password(),
			'post_name'      => $post->slug(),
			'post_modified'  => $post->modified(),
			'post_parent'    => $post->parent() ? $post->parent()->id() : null,
			'menu_order'     => $post->menuOrder(),
		];
	}

	protected function hydrate(array $data)
	{
		$ref    = $this->em->getReflection('Post');
		$entity = $this->em->getEntityFromReflection($ref);
		
		foreach ($ref->getProperties() as $prop)
		{
			$name  = $prop->getName();
			$doc   = $this->parseDocComment($prop->getDocComment());
			$value = null;
			$skip  = true;

			//if ( ! isset($doc['column']) and ! isset($doc['meta']))
				//continue;

			if (isset($doc['column']))
			{
				$skip  = false;
				$name  = $doc['column'] ?: $name;
				$value = isset($data[$name]) ? $data[$name] : null;
			}

			if (isset($doc['meta']))
			{
				$skip = false;

				if (function_exists('get_field'))
				{
					$value = get_field($doc['meta'], $data['ID']);
				}
				else
				{
					$value = get_post_meta($data['ID'], $doc['meta'], true);
				}
			}

			if (isset($doc['belongsToPost']))
			{
				$skip = false;
				$id   = $data[$doc['belongsToPost']];

				$value = function() use ($id)
				{
					return $this->em->getRepository('Post')->postOfId($id);
				};
			}

			if ($skip)
				continue;

			$prop->setAccessible(true);
			$prop->setValue($entity, $value);
		}

		$entity->setNative($data);

		return $entity;
	}

}