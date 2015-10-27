<?php

namespace Fire\Model\AbstractPost;

use Fire\Contracts\Model\EntityMapper as EntityMapperContract;
use Fire\Contracts\Model\Entity as EntityContract;
use Fire\Contracts\Model\User\UserRepository as UserRepositoryContract;
use Fire\Contracts\Model\Upload\UploadRepository as UploadRepositoryContract;
use Fire\Contracts\Model\Comment\CommentRepository as CommentRepositoryContract;

class AbstractPostEntityMapper implements EntityMapperContract
{
    /**
     * @var Fire\Contracts\Model\User\UserRepository
     */
    protected $userRepository;

    /**
     * @var Fire\Contracts\Model\Upload\UploadRepository
     */
    protected $uploadRepository;

    /**
     * @var Fire\Contracts\Model\Comment\CommentRepository
     */
    protected $commentRepository;

    /**
     * @param Fire\Contracts\Model\User\UserRepository        $userRepository
     * @param Fire\Contracts\Model\Upload\UploadRepository    $uploadRepository
     * @param Fire\Contracts\Model\Comment\CommentRepository  $commentRepository
     */
    public function __construct(
        UserRepositoryContract $userRepository,
        UploadRepositoryContract $uploadRepository,
        CommentRepositoryContract $commentRepository = null
    ) {
        $this->userRepository     = $userRepository;
        $this->uploadRepository   = $uploadRepository;
        $this->commentRepository  = $commentRepository;
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
        $entity->setAuthorId($id = $data['post_author']);

        $entity->setAuthor(function () use ($id) {
            return $this->userRepository->userOfId($id);
        });

        $id = $data['ID'];

        $entity->setFeaturedImage(function () use ($id) {
            $upload = null;

            if ($uId = get_post_thumbnail_id($id)) {
                $upload = $this->uploadRepository->uploadOfId($uId);
            }

            return $upload;
        });

        if ($this->commentRepository) {
            $entity->setComments(function () use ($id) {
                return $this->commentRepository->commentsForPost($id);
            });
        }
    }
}
