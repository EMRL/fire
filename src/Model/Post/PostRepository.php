<?php

namespace Fire\Model\Post;

use Fire\Foundation\Collection;

class PostRepository extends \Fire\Model\Repository {

	public $entityClass = 'Fire\Model\Post\Post';

	public function postOfId($id)
	{
		$post = get_post($id, ARRAY_A);

		if ($post and $post['post_type'] === Post::TYPE)
		{
			$post = $this->hydrate($post);
		}

		return $post;
	}

	public function postOfSlug($slug)
	{
		$post = get_page_by_path($slug, ARRAY_A, Post::TYPE);

		if ($post)
		{
			$post = $this->hydrate($post);
		}

		return $post;
	}

	public function find(array $args = [])
	{
		$args = array_replace_recursive([
			'post_type'        => Post::TYPE,
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

	protected function hydrate(array $data)
	{
		$ref    = $this->em->getEntityReflection('Post');
		$entity = $this->em->getEntityFromReflection($ref);
		
		foreach ($ref->getProperties() as $prop)
		{
			$name  = $prop->getName();
			$meta  = $this->em->getMetaData($prop->getDocComment());
			$value = false;

			if ( ! $meta->get('Column'))
				continue;

			// Maps property to post table column
			if ($column = $meta->get('Column'))
			{
				$name  = $column->get('name', $name);
				$value = isset($data[$name]) ? $data[$name] : false;
			}

			// Maps property to meta table
			if ($_meta = $meta->get('Meta'))
			{
				$name = $_meta->get('key', $name);

				if (function_exists('get_field'))
				{
					$value = get_field($name, $data['ID']);
				}
				else
				{
					$value = get_post_meta($data['ID'], $name, true);
				}
			}

			// Maps to one to many relationship
			if ($oneToMany = $meta->get('OneToMany'))
			{
				if (isset($data[$name]) and $data[$name])
				{
					$id         = $data[$name];
					$entityName = $oneToMany->get('entityName');
					$method     = $oneToMany->get('method');

					$value = function() use ($id, $entityName, $method)
					{
						return $this->em->getRepository($entityName)->$method($id);
					};
				}
			}

			if ($value)
			{
				$prop->setAccessible(true);
				$prop->setValue($entity, $value);
			}
		}

		$entity->setNative($data);

		return $entity;
	}

}