<?php

namespace Fire\Model\Post;

use Fire\Model\EntityMapper;
use Fire\Contracts\Model\Entity as EntityContract;

class PostEntityMapper extends EntityMapper {

	public function map(array $data, EntityContract $entity)
	{
		$entity->setId($data['ID']);
		$entity->setDate($data['post_date']);
		$entity->setContent($data['post_content']);
		$entity->setTitle($data['post_title']);
		$entity->setExcerpt($data['post_excerpt']);
		$entity->setStatus($data['post_status']);
		$entity->setCommentStatus($data['comment_status']);
		$entity->setPingStatus($data['ping_status']);
		$entity->setPassword($data['post_password']);
		$entity->setSlug($data['post_name']);
		$entity->setModified($data['post_modified']);
		$entity->setMenuOrder($data['menu_order']);
		$entity->setType($data['post_type']);
		$entity->setNative($data);

		// Relations
		$entity->setAuthor(function() use ($data)
		{
			return $this->em->getRepository('user')->userOfId($data['post_author']);
		});

		$entity->setParent(function() use ($data)
		{
			return $this->em->getRepository($data['post_type'])->postOfId($data['post_parent']);
		});

		return $entity;
	}

}