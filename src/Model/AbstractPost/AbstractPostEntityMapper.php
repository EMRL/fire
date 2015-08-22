<?php

namespace Fire\Model\AbstractPost;

use Fire\Contracts\Model\EntityMapper as EntityMapperContract;
use Fire\Contracts\Model\Entity as EntityContract;
use Fire\Contracts\Model\User\UserRepository as UserRepositoryContract;
use Fire\Contracts\Model\Repository as RepositoryContract;

class AbstractPostEntityMapper implements EntityMapperContract
{
    /**
     * @var Fire\Contracts\Model\User\UserRepository
     */
    protected $userRepository;

    /**
     * @param Fire\Contracts\Model\User\UserRepository  $userRepository
     */
    public function __construct(UserRepositoryContract $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function map(EntityContract $entity, array $data)
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
        $id = $data['post_author'];

        $entity->setAuthor(function () use ($id) {
            return $this->userRepository->userOfId($id);
        });
    }

}
